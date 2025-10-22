import Swal from "sweetalert2";

window.Swal = Swal;

// SweetAlert Toast Handler - Fully Responsive & Modern
window.showSweetAlert = function (type, title, message) {
    // Color configurations for each alert type
    const alertStyles = {
        success: {
            gradient: 'linear-gradient(135deg, #10b981, #059669)',
            borderColor: '#10b981'
        },
        error: {
            gradient: 'linear-gradient(135deg, #ef4444, #dc2626)',
            borderColor: '#ef4444'
        },
        warning: {
            gradient: 'linear-gradient(135deg, #f59e0b, #d97706)',
            borderColor: '#f59e0b'
        },
        info: {
            gradient: 'linear-gradient(135deg, #3b82f6, #2563eb)',
            borderColor: '#3b82f6'
        }
    };

    const currentStyle = alertStyles[type] || alertStyles.info;

    // Inject responsive styles once
    if (!document.getElementById('swal-responsive-styles')) {
        const styleSheet = document.createElement('style');
        styleSheet.id = 'swal-responsive-styles';
        styleSheet.textContent = `
            /* Animations */
            @keyframes swalSlideIn {
                0% { 
                    transform: translateX(120%);
                    opacity: 0;
                }
                70% { 
                    transform: translateX(-5px);
                    opacity: 1;
                }
                100% { 
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            @keyframes swalSlideOut {
                0% { 
                    transform: translateX(0);
                    opacity: 1;
                }
                100% { 
                    transform: translateX(120%);
                    opacity: 0;
                }
            }
            
            /* Base toast container - Mobile first */
            .swal-toast-responsive {
                animation: swalSlideIn 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55) !important;
                border-radius: 8px !important;
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2) !important;
                padding: 12px !important;
                min-width: 280px !important;
                max-width: 340px !important;
                width: 90vw !important;
            }
            
            /* Tablet */
            @media (min-width: 640px) {
                .swal-toast-responsive {
                    min-width: 320px !important;
                    max-width: 380px !important;
                    width: auto !important;
                    padding: 14px !important;
                }
            }
            
            /* Desktop */
            @media (min-width: 1024px) {
                .swal-toast-responsive {
                    min-width: 340px !important;
                    max-width: 400px !important;
                    padding: 16px !important;
                    border-radius: 10px !important;
                }
            }
            
            /* Hide animation */
            .swal-toast-responsive.swal2-hide {
                animation: swalSlideOut 0.3s ease-in forwards !important;
            }
            
            /* Icon container */
            .swal-toast-responsive .swal2-icon {
                width: 2em !important;
                height: 2em !important;
                margin: 0 0.5em 0 0 !important;
                border-width: 0.15em !important;
            }
            
            /* Icon colors - white for all types */
            .swal-toast-responsive .swal2-icon {
                color: #ffffff !important;
                border-color: #ffffff !important;
            }
            
            .swal-toast-responsive .swal2-icon::before,
            .swal-toast-responsive .swal2-icon::after {
                background-color: #ffffff !important;
            }
            
            .swal-toast-responsive .swal2-icon.swal2-success .swal2-success-ring {
                border-color: rgba(255, 255, 255, 0.3) !important;
            }
            
            .swal-toast-responsive .swal2-icon.swal2-success [class^='swal2-success-line'] {
                background-color: #ffffff !important;
            }
            
            .swal-toast-responsive .swal2-icon.swal2-error [class^='swal2-x-mark-line'] {
                background-color: #ffffff !important;
            }
            
            .swal-toast-responsive .swal2-icon.swal2-warning {
                color: #ffffff !important;
                border-color: #ffffff !important;
            }
            
            /* Title styling */
            .swal-toast-responsive .swal2-title {
                color: #ffffff !important;
                font-weight: 600 !important;
                font-size: 15px !important;
                margin: 0 0 4px 0 !important;
                line-height: 1.3 !important;
            }
            
            @media (min-width: 1024px) {
                .swal-toast-responsive .swal2-title {
                    font-size: 16px !important;
                }
            }
            
            /* Message styling */
            .swal-toast-responsive .swal2-html-container {
                color: rgba(255, 255, 255, 0.95) !important;
                font-size: 13px !important;
                line-height: 1.4 !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            
            @media (min-width: 1024px) {
                .swal-toast-responsive .swal2-html-container {
                    font-size: 14px !important;
                }
            }
            
            /* Close button */
            .swal-toast-responsive .swal2-close {
                color: rgba(255, 255, 255, 0.8) !important;
                font-size: 18px !important;
                width: 24px !important;
                height: 24px !important;
                line-height: 24px !important;
                right: 8px !important;
                top: 8px !important;
                transition: all 0.2s ease !important;
            }
            
            @media (min-width: 1024px) {
                .swal-toast-responsive .swal2-close {
                    font-size: 20px !important;
                    width: 28px !important;
                    height: 28px !important;
                    line-height: 28px !important;
                    right: 10px !important;
                    top: 10px !important;
                }
            }
            
            .swal-toast-responsive .swal2-close:hover {
                color: #ffffff !important;
                transform: scale(1.15) !important;
            }
            
            /* Progress bar */
            .swal-toast-responsive .swal2-timer-progress-bar {
                background: rgba(255, 255, 255, 0.3) !important;
                height: 3px !important;
            }
        `;
        document.head.appendChild(styleSheet);
    }

    // Display the alert
    Swal.fire({
        icon: type,
        title: title,
        html: message,
        toast: true,
        position: 'bottom-end',
        timer: 4000,
        timerProgressBar: true,
        showConfirmButton: false,
        showCloseButton: true,
        background: currentStyle.gradient,
        customClass: {
            popup: 'swal-toast-responsive'
        },
        didOpen: (toastElement) => {
            toastElement.style.border = `2px solid ${currentStyle.borderColor}`;
            toastElement.addEventListener('mouseenter', Swal.stopTimer);
            toastElement.addEventListener('mouseleave', Swal.resumeTimer);
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
