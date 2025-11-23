/**
 * CEP Lookup Module - Professional Implementation
 * Otimizado para performance, UX e manutenibilidade
 * Padrões: Debounce, Cache, AbortController, Error Handling
 */

(function() {
    'use strict';

    // ==================== CONFIGURAÇÃO ====================
    const CONFIG = {
        API_URL: 'https://viacep.com.br/ws/',
        DEBOUNCE_DELAY: 300, // Reduzido para resposta mais rápida
        CACHE_DURATION: 1800000, // 30 minutos
        REQUEST_TIMEOUT: 5000, // Máximo 5 segundos
        RETRY_ATTEMPTS: 1 // Apenas 1 retry para ser mais rápido
    };

    // ==================== CACHE MANAGER ====================
    class CepCache {
        constructor() {
            this.cache = new Map();
        }

        set(cep, data) {
            this.cache.set(cep, {
                data: data,
                timestamp: Date.now()
            });
        }

        get(cep) {
            const cached = this.cache.get(cep);
            if (!cached) return null;
            
            const age = Date.now() - cached.timestamp;
            if (age > CONFIG.CACHE_DURATION) {
                this.cache.delete(cep);
                return null;
            }
            
            return cached.data;
        }

        clear() {
            this.cache.clear();
        }
    }

    // ==================== ESTADO DA APLICAÇÃO ====================
    const state = {
        cache: new CepCache(),
        activeController: null,
        debounceTimer: null,
        lastSearchedCep: '',
        isLoading: false,
        elements: {}
    };

    // ==================== UTILITÁRIOS ====================
    const Utils = {
        formatCep(value) {
            const digits = value.replace(/\D/g, '');
            return digits.length > 5 
                ? `${digits.slice(0, 5)}-${digits.slice(5, 8)}`
                : digits;
        },

        extractDigits(value) {
            return value.replace(/\D/g, '');
        },

        isValidCep(cep) {
            const digits = this.extractDigits(cep);
            return digits.length === 8 && /^\d{8}$/.test(digits);
        },

        debounce(func, delay) {
            return function(...args) {
                if (state.debounceTimer) {
                    clearTimeout(state.debounceTimer);
                }
                state.debounceTimer = setTimeout(() => func.apply(this, args), delay);
            };
        }
    };

    // ==================== UI MANAGER ====================
    const UI = {
        setFieldsReadonly(readonly) {
            ['estado', 'cidade', 'bairro', 'rua'].forEach(id => {
                const field = state.elements[id];
                if (field) {
                    field.readOnly = readonly;
                    field.style.opacity = readonly ? '0.7' : '1';
                }
            });
        },

        fillFields(data) {
            state.elements.estado.value = data.uf || '';
            state.elements.cidade.value = data.localidade || '';
            state.elements.bairro.value = data.bairro || '';
            state.elements.rua.value = data.logradouro || '';
            
            // Auto-focus em número se houver logradouro
            if (data.logradouro && state.elements.numero) {
                setTimeout(() => state.elements.numero.focus(), 100);
            }
        },

        clearFields() {
            ['estado', 'cidade', 'bairro', 'rua'].forEach(id => {
                if (state.elements[id]) {
                    state.elements[id].value = '';
                }
            });
        },

        showLoading() {
            if (state.isLoading) return;
            state.isLoading = true;

            const indicator = document.createElement('span');
            indicator.id = 'cep-loading-indicator';
            indicator.innerHTML = `
                <svg width="16" height="16" viewBox="0 0 16 16" style="animation: spin 0.6s linear infinite; vertical-align: middle; margin-left: 8px;">
                    <circle cx="8" cy="8" r="6" fill="none" stroke="#11b85a" stroke-width="2" stroke-dasharray="30" stroke-dashoffset="0"/>
                </svg>
                <style>
                    @keyframes spin { to { transform: rotate(360deg); } }
                </style>
            `;
            indicator.style.cssText = 'display: inline-block; color: #11b85a; font-size: 12px; font-weight: 600;';

            state.elements.cep.insertAdjacentElement('afterend', indicator);
            state.elements.cep.style.borderColor = '#11b85a';
            this.setFieldsReadonly(true);
        },

        hideLoading() {
            state.isLoading = false;
            const indicator = document.getElementById('cep-loading-indicator');
            if (indicator) {
                indicator.remove();
            }
            state.elements.cep.style.borderColor = '';
            this.setFieldsReadonly(true);
        },

        showError(message, type = 'error') {
            this.hideLoading();
            
            const overlay = document.createElement('div');
            overlay.className = 'cep-modal-overlay';
            overlay.innerHTML = `
                <div class="cep-modal-content">
                    <div class="cep-modal-icon ${type}">${type === 'error' ? '❌' : 'ℹ️'}</div>
                    <h3 class="cep-modal-title">${type === 'error' ? 'CEP Inválido' : 'Atenção'}</h3>
                    <p class="cep-modal-message">${message}</p>
                    <button class="cep-modal-btn">Entendido</button>
                </div>
            `;

            const style = document.createElement('style');
            style.textContent = `
                .cep-modal-overlay {
                    position: fixed; inset: 0; background: rgba(0,0,0,0.75);
                    display: flex; align-items: center; justify-content: center;
                    z-index: 9999; animation: fadeIn 0.15s ease-out;
                    backdrop-filter: blur(3px);
                }
                .cep-modal-content {
                    background: white; padding: 32px 28px; border-radius: 16px;
                    max-width: 440px; width: 90%; text-align: center;
                    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
                    animation: slideUp 0.2s ease-out;
                }
                .cep-modal-icon { 
                    font-size: 56px; margin-bottom: 12px; 
                    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
                }
                .cep-modal-title {
                    margin: 0 0 12px; color: #222; font-size: 20px; 
                    font-weight: 700; letter-spacing: -0.3px;
                }
                .cep-modal-message { 
                    margin: 0 0 24px; color: #555; font-size: 15px; 
                    line-height: 1.6; font-weight: 500;
                }
                .cep-modal-btn {
                    background: linear-gradient(135deg, #11b85a 0%, #0fa04e 100%);
                    color: white; border: none; padding: 14px 36px; 
                    border-radius: 8px; font-weight: 700; cursor: pointer; 
                    transition: all 0.2s; font-size: 15px; width: 100%;
                    box-shadow: 0 4px 12px rgba(17,184,90,0.3);
                }
                .cep-modal-btn:hover { 
                    transform: translateY(-2px); 
                    box-shadow: 0 6px 16px rgba(17,184,90,0.4);
                }
                .cep-modal-btn:active { transform: translateY(0); }
                @keyframes fadeIn { 
                    from { opacity: 0; } 
                    to { opacity: 1; } 
                }
                @keyframes slideUp {
                    from { opacity: 0; transform: translateY(20px); }
                    to { opacity: 1; transform: translateY(0); }
                }
            `;

            document.head.appendChild(style);
            document.body.appendChild(overlay);

            const closeModal = () => {
                overlay.style.animation = 'fadeOut 0.15s ease-in';
                setTimeout(() => {
                    overlay.remove();
                    style.remove();
                }, 150);
                state.elements.cep.focus();
            };

            overlay.querySelector('.cep-modal-btn').onclick = closeModal;
            overlay.onclick = (e) => { if (e.target === overlay) closeModal(); };
            document.addEventListener('keydown', function escHandler(e) {
                if (e.key === 'Escape') {
                    closeModal();
                    document.removeEventListener('keydown', escHandler);
                }
            });
            
            // Adicionar animação de saída
            const styleSheet = document.styleSheets[document.styleSheets.length - 1];
            styleSheet.insertRule('@keyframes fadeOut { from { opacity: 1; } to { opacity: 0; } }', styleSheet.cssRules.length);
        },

        showSuccess() {
            const successIcon = document.createElement('span');
            successIcon.innerHTML = '✓';
            successIcon.style.cssText = 'color: #11b85a; font-weight: bold; font-size: 18px; margin-left: 8px;';
            state.elements.cep.insertAdjacentElement('afterend', successIcon);
            setTimeout(() => successIcon.remove(), 2000);
        }
    };

    // ==================== API SERVICE ====================
    const ApiService = {
        async fetchWithTimeout(url, options = {}) {
            // Usa o controller ativo (para permitir cancelamento) ou cria um novo para o timeout
            const controller = state.activeController || new AbortController();
            const timeout = setTimeout(() => controller.abort(), CONFIG.REQUEST_TIMEOUT);

            try {
                const response = await fetch(url, {
                    ...options,
                    signal: controller.signal
                });
                clearTimeout(timeout);
                return response;
            } catch (error) {
                clearTimeout(timeout);
                throw error;
            }
        },

        async fetchCep(cepDigits, attempt = 1) {
            // Verificar cache primeiro
            const cached = state.cache.get(cepDigits);
            if (cached) {
                console.log(`✓ CEP ${cepDigits} carregado do cache`);
                return cached;
            }

            try {
                const response = await this.fetchWithTimeout(
                    `${CONFIG.API_URL}${cepDigits}/json/`,
                    { method: 'GET' }
                );

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }

                const data = await response.json();

                if (data.erro) {
                    throw new Error('CEP_NOT_FOUND');
                }

                // Salvar no cache
                state.cache.set(cepDigits, data);
                console.log(`✓ CEP ${cepDigits} buscado da API e cacheado`);
                
                return data;

            } catch (error) {
                if (error.name === 'AbortError') {
                    throw new Error('REQUEST_CANCELLED');
                }

                // Retry logic - mais rápido
                if (attempt < CONFIG.RETRY_ATTEMPTS) {
                    console.log(`⟳ Tentativa ${attempt + 1} para CEP ${cepDigits}`);
                    await new Promise(resolve => setTimeout(resolve, 300));
                    return this.fetchCep(cepDigits, attempt + 1);
                }

                throw error;
            }
        }
    };

    // ==================== CEP HANDLER ====================
    const CepHandler = {
        async lookup(cepDigits) {
            // Validações
            if (!Utils.isValidCep(cepDigits)) return;
            if (state.lastSearchedCep === cepDigits) return;

            // Cancelar requisição anterior
            if (state.activeController) {
                try { state.activeController.abort(); } catch (_) {}
            }
            state.activeController = new AbortController();

            state.lastSearchedCep = cepDigits;
            UI.showLoading();
            UI.clearFields();

            try {
                const data = await ApiService.fetchCep(cepDigits);
                UI.fillFields(data);
                UI.hideLoading();
                UI.showSuccess();
                // Limpa controller ativo após conclusão bem-sucedida
                state.activeController = null;

            } catch (error) {
                UI.hideLoading();

                if (error.message === 'REQUEST_CANCELLED') {
                    return; // Silenciar cancelamentos
                }

                if (error.message === 'CEP_NOT_FOUND') {
                    UI.showError(
                        `O CEP <strong>${Utils.formatCep(cepDigits)}</strong> não foi encontrado nos Correios.<br><br>` +
                        `Verifique se digitou corretamente ou tente outro CEP.`,
                        'error'
                    );
                    state.elements.cep.value = '';
                    state.lastSearchedCep = '';
                } else if (error.name === 'AbortError') {
                    UI.showError(
                        'A busca do CEP excedeu o tempo limite de 5 segundos.<br><br>' +
                        'Verifique sua conexão com a internet e tente novamente.',
                        'error'
                    );
                } else {
                    UI.showError(
                        'Não foi possível buscar o CEP no momento.<br><br>' +
                        'Verifique sua conexão com a internet e tente novamente.',
                        'error'
                    );
                    console.error('Erro na busca do CEP:', error);
                }

                UI.clearFields();
                // Reset controller após erro
                state.activeController = null;
            }
        },

        debouncedLookup: null,

        init() {
            this.debouncedLookup = Utils.debounce(
                (cep) => this.lookup(cep),
                CONFIG.DEBOUNCE_DELAY
            );
        }
    };

    // ==================== EVENT HANDLERS ====================
    const Events = {
        onInput(e) {
            const formatted = Utils.formatCep(e.target.value);
            e.target.value = formatted;

            const digits = Utils.extractDigits(formatted);
            
            if (digits.length === 8) {
                CepHandler.debouncedLookup(digits);
            } else {
                UI.clearFields();
                state.lastSearchedCep = '';
            }
        },

        onBlur(e) {
            const digits = Utils.extractDigits(e.target.value);
            
            if (digits.length > 0 && digits.length < 8) {
                UI.showError(
                    'O CEP está incompleto.<br><br>' +
                    'Digite os 8 dígitos do CEP para continuar.',
                    'error'
                );
                e.target.value = '';
                UI.clearFields();
                state.lastSearchedCep = '';
            }
        },

        onPaste(e) {
            e.preventDefault();
            const pastedText = (e.clipboardData || window.clipboardData).getData('text');
            const digits = Utils.extractDigits(pastedText);
            
            if (digits.length <= 8) {
                e.target.value = Utils.formatCep(digits);
                if (digits.length === 8) {
                    CepHandler.lookup(digits);
                }
            }
        },

        onFormSubmit(e) {
            const cep = Utils.extractDigits(state.elements.cep.value);
            
            if (!Utils.isValidCep(cep)) {
                e.preventDefault();
                UI.showError(
                    'O CEP é obrigatório para continuar.<br><br>' +
                    'Digite um CEP válido com 8 dígitos.',
                    'error'
                );
                state.elements.cep.focus();
                return false;
            }

            // Verificar se campos obrigatórios foram preenchidos
            const requiredFields = ['estado', 'cidade', 'bairro', 'rua'];
            const emptyFields = requiredFields.filter(id => !state.elements[id]?.value);
            
            if (emptyFields.length > 0) {
                e.preventDefault();
                UI.showError(
                    'O endereço não foi preenchido automaticamente.<br><br>' +
                    'Aguarde a busca do CEP terminar antes de enviar.',
                    'error'
                );
                state.elements.cep.focus();
                return false;
            }
        }
    };

    // ==================== INICIALIZAÇÃO ====================
    function init() {
        // Verificar se elementos existem
        const cepInput = document.getElementById('cep');
        if (!cepInput) {
            console.warn('CEP input não encontrado. Script não será inicializado.');
            return;
        }

        // Mapear elementos
        state.elements = {
            cep: cepInput,
            estado: document.getElementById('estado'),
            cidade: document.getElementById('cidade'),
            bairro: document.getElementById('bairro'),
            rua: document.getElementById('rua'),
            numero: document.getElementById('numero'),
            form: document.querySelector('form')
        };

        // Inicializar handler
        CepHandler.init();

        // Registrar eventos
        state.elements.cep.addEventListener('input', Events.onInput);
        state.elements.cep.addEventListener('blur', Events.onBlur);
        state.elements.cep.addEventListener('paste', Events.onPaste);
        
        if (state.elements.form) {
            state.elements.form.addEventListener('submit', Events.onFormSubmit);
        }

        // Configurar campos como readonly inicialmente
        UI.setFieldsReadonly(true);

        console.log('✓ CEP Lookup Module inicializado com sucesso');
    }

    // Executar quando DOM estiver pronto
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
 
