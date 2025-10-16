import Swal from "sweetalert2";

window.Swal = Swal;

// SweetAlert Toast Handler
window.showSweetAlert = function (type, title, message) {
    // Define colors and configurations for each type
    const typeConfig = {
        success: {
            bg: 'linear-gradient(135deg, #10b981, #059669)',
            border: '#10b981',
            icon: '#ffffff'
        },
        error: {
            bg: 'linear-gradient(135deg, #ef4444, #dc2626)',
            border: '#ef4444',
            icon: '#ffffff'
        },
        warning: {
            bg: 'linear-gradient(135deg, #f59e0b, #d97706)',
            border: '#f59e0b',
            icon: '#ffffff'
        },
        info: {
            bg: 'linear-gradient(135deg, #3b82f6, #2563eb)',
            border: '#3b82f6',
            icon: '#ffffff'
        }
    };

    const config = typeConfig[type] || typeConfig.info;

    // Inject styles if not already present
    if (!document.getElementById('sweet-alert-styles')) {
        const style = document.createElement('style');
        style.id = 'sweet-alert-styles';
        style.textContent = `
            /* Slide in from bottom-right with bounce */
            @keyframes slideInBottomRight {
                0% { 
                    transform: translateX(100%) translateY(100%); 
                    opacity: 0; 
                    scale: 0.8;
                }
                60% { 
                    transform: translateX(-5px) translateY(-5px); 
                    opacity: 1; 
                    scale: 1.02;
                }
                80% { 
                    transform: translateX(2px) translateY(2px); 
                    scale: 0.98;
                }
                100% { 
                    transform: translateX(0) translateY(0); 
                    opacity: 1; 
                    scale: 1;
                }
            }
            
            /* Slide out to bottom-right */
            @keyframes slideOutBottomRight {
                0% { 
                    transform: translateX(0) translateY(0); 
                    opacity: 1; 
                    scale: 1;
                }
                100% { 
                    transform: translateX(100%) translateY(50%); 
                    opacity: 0; 
                    scale: 0.9;
                }
            }
            
            .custom-toast {
                background: ${config.bg} !important;
                border: 2px solid ${config.border} !important;
                border-radius: 10px !important;
                box-shadow: 0 3px 6px rgba(0,0,0,0.10), 0 1px 3px rgba(0,0,0,0.08) !important;
                backdrop-filter: blur(10px) !important;
                animation: slideInBottomRight 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55) !important;
                min-width: 240px !important;
                max-width: 280px !important;
                width: 85vw !important;
            }
            
            @media (min-width: 768px) {
                .custom-toast {
                    min-width: 320px !important;
                    max-width: 400px !important;
                    width: auto !important;
                    border-radius: 12px !important;
                }
            }
            
            .custom-toast.swal2-hide {
                animation: slideOutBottomRight 0.4s ease-in forwards !important;
            }
            
            .custom-toast .swal2-title {
                color: #ffffff !important;
                font-weight: 600 !important;
                font-size: 13px !important;
                margin-bottom: 4px !important;
                word-wrap: break-word !important;
                white-space: normal !important;
            }
            
            @media (min-width: 768px) {
                .custom-toast .swal2-title {
                    font-size: 16px !important;
                    margin-bottom: 8px !important;
                }
            }
            
            .custom-toast .swal2-html-container {
                color: rgba(255,255,255,0.95) !important;
                font-size: 11px !important;
                line-height: 1.3 !important;
                margin: 0 !important;
                padding: 0 !important;
                word-wrap: break-word !important;
                white-space: normal !important;
                overflow-wrap: break-word !important;
                max-width: 100% !important;
                margin-left: 8px !important;
                text-align: left !important;
            }
            
            @media (min-width: 768px) {
                .custom-toast .swal2-html-container {
                    font-size: 14px !important;
                    line-height: 1.5 !important;
                    margin-left: 15px !important;
                }
            }
            
            .custom-toast .swal2-content {
                padding: 0 10px 10px 10px !important;
                margin: 0 !important;
            }
            
            @media (min-width: 768px) {
                .custom-toast .swal2-content {
                    padding: 0 20px 20px 20px !important;
                }
            }
            
            .custom-toast .swal2-icon {
                color: ${config.icon} !important;
                border-color: ${config.icon} !important;
                margin: 6px auto 8px auto !important;
                width: 1.8em !important;
                height: 1.8em !important;
            }
            
            @media (min-width: 768px) {
                .custom-toast .swal2-icon {
                    margin: 10px auto 15px auto !important;
                    width: 2.5em !important;
                    height: 2.5em !important;
                }
            }
            
            .custom-toast .swal2-icon::before,
            .custom-toast .swal2-icon::after {
                background-color: ${config.icon} !important;
            }
            
            .custom-toast .swal2-icon.swal2-success .swal2-success-ring {
                border-color: rgba(255,255,255,0.3) !important;
            }
            
            .custom-toast .swal2-icon.swal2-success [class^='swal2-success-line'] {
                background-color: ${config.icon} !important;
            }
            
            .custom-toast .swal2-icon.swal2-error .swal2-x-mark .swal2-x-mark-line-left,
            .custom-toast .swal2-icon.swal2-error .swal2-x-mark .swal2-x-mark-line-right {
                background-color: ${config.icon} !important;
            }
            
            .custom-toast .swal2-icon.swal2-warning {
                color: ${config.icon} !important;
            }
            
            .custom-toast .swal2-timer-progress-bar {
                background: rgba(255,255,255,0.3) !important;
                height: 4px !important;
                border-radius: 0 0 10px 10px !important;
            }
            
            .custom-toast .swal2-close {
                color: rgba(255,255,255,0.8) !important;
                font-size: 20px !important;
                right: 8px !important;
                top: 8px !important;
            }
            
            .custom-toast .swal2-close:hover {
                color: #ffffff !important;
                transform: scale(1.1) !important;
            }
        `;
        document.head.appendChild(style);
    }

    // Show the alert with dynamic background
    Swal.fire({
        icon: type,
        title: title,
        html: message,
        timer: 4000,
        toast: true,
        position: 'bottom-end',
        showConfirmButton: false,
        showCloseButton: true,
        timerProgressBar: true,
        background: config.bg,
        customClass: {
            popup: 'custom-toast'
        },
        didOpen: (toast) => {
            // Apply dynamic border color
            toast.style.border = `2px solid ${config.border}`;

            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        },
        willClose: () => {
            // Add a slight delay before the next toast can appear
            setTimeout(() => { }, 100);
        }
    });
};

// Auto-render SweetAlert from PHP session data
document.addEventListener('DOMContentLoaded', function () {
    if (window.swalData) {
        showSweetAlert(window.swalData.type, window.swalData.title, window.swalData.message);
    }
});

// Page Loading Overlay
window.PageLoader = {
    show: function() {
        const loader = document.getElementById('page-loader');
        if (loader) {
            loader.classList.remove('hidden');
        }
    },
    hide: function() {
        const loader = document.getElementById('page-loader');
        if (loader) {
            loader.classList.add('hidden');
        }
    }
};

// Hide loader only when ALL resources are fully loaded (images, CSS, JS, fonts, etc.)
window.addEventListener('load', function() {
    // This fires when the entire page including all dependent resources has finished loading
    PageLoader.hide();
});
