import Swal from "sweetalert2";

window.Swal = Swal;

// SweetAlert Toast Handler - Responsive & Modern
window.showSweetAlert = function (type, title, message) {
    // Color configurations for each alert type
    const alertStyles = {
        success: {
            gradient: 'linear-gradient(135deg, #10b981, #059669)',
            borderColor: '#10b981',
            iconColor: '#ffffff'
        },
        error: {
            gradient: 'linear-gradient(135deg, #ef4444, #dc2626)',
            borderColor: '#ef4444',
            iconColor: '#ffffff'
        },
        warning: {
            gradient: 'linear-gradient(135deg, #f59e0b, #d97706)',
            borderColor: '#f59e0b',
            iconColor: '#ffffff'
        },
        info: {
            gradient: 'linear-gradient(135deg, #3b82f6, #2563eb)',
            borderColor: '#3b82f6',
            iconColor: '#ffffff'
        }
    };

    const currentStyle = alertStyles[type] || alertStyles.info;

    // Inject responsive styles once
    if (!document.getElementById('swal-responsive-styles')) {
        const styleSheet = document.createElement('style');
        styleSheet.id = 'swal-responsive-styles';
        styleSheet.textContent = `
            /* Smooth slide-in animation */
            @keyframes swalSlideIn {
                0% { 
                    transform: translateX(120%) translateY(20px);
                    opacity: 0;
                }
                70% { 
                    transform: translateX(-8px) translateY(-2px);
                    opacity: 1;
                }
                100% { 
                    transform: translateX(0) translateY(0);
                    opacity: 1;
                }
            }
            
            /* Smooth slide-out animation */
            @keyframes swalSlideOut {
                0% { 
                    transform: translateX(0) translateY(0);
                    opacity: 1;
                }
                100% { 
                    transform: translateX(120%) translateY(10px);
                    opacity: 0;
                }
            }
            
            /* Base toast styles - Mobile first */
            .swal-toast-responsive {
                animation: swalSlideIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55) !important;
                border-radius: 8px !important;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
                padding: 8px 10px !important;
                min-width: 270px !important;
                max-width: 310px !important;
                width: 88vw !important;
            }
            
            /* Tablet screens */
            @media (min-width: 640px) {
                .swal-toast-responsive {
                    min-width: 320px !important;
                    max-width: 360px !important;
                    width: auto !important;
                    padding: 14px !important;
                }
            }
            
            /* Desktop screens */
            @media (min-width: 1024px) {
                .swal-toast-responsive {
                    min-width: 340px !important;
                    max-width: 380px !important;
                    border-radius: 10px !important;
                    padding: 16px !important;
                }
            }
            
            /* Hide animation */
            .swal-toast-responsive.swal2-hide {
                animation: swalSlideOut 0.3s ease-in forwards !important;
            }
            
            /* Title styling - Mobile */
            .swal-toast-responsive .swal2-title {
                color: #ffffff !important;
                font-weight: 600 !important;
                font-size: 13.5px !important;
                margin: 0 0 3px 10px !important;
                line-height: 1.3 !important;
                text-align: left !important;
            }
            
            /* Title - Tablet & Desktop */
            @media (min-width: 640px) {
                .swal-toast-responsive .swal2-title {
                    font-size: 15px !important;
                    margin-top: 6px !important;
                    margin-bottom: 4px !important;
                    margin-left: 14px !important;
                }
            }
            
            @media (min-width: 1024px) {
                .swal-toast-responsive .swal2-title {
                    font-size: 16px !important;
                    margin-top: 8px !important;
                    margin-left: 16px !important;
                }
            }
            
            /* Message styling - Mobile */
            .swal-toast-responsive .swal2-html-container {
                color: rgba(255, 255, 255, 0.95) !important;
                font-size: 11.5px !important;
                line-height: 1.35 !important;
                margin: 0 0 0 10px !important;
                padding: 0 !important;
                text-align: left !important;
            }
            
            /* Message - Tablet & Desktop */
            @media (min-width: 640px) {
                .swal-toast-responsive .swal2-html-container {
                    font-size: 13px !important;
                    margin-left: 14px !important;
                }
            }
            
            @media (min-width: 1024px) {
                .swal-toast-responsive .swal2-html-container {
                    font-size: 14px !important;
                    line-height: 1.4 !important;
                    margin-left: 16px !important;
                }
            }
            
            /* Icon styling - Mobile */
            .swal-toast-responsive .swal2-icon {
                margin: 8px 12px 8px 8px !important;
                width: 1.95em !important;
                height: 1.95em !important;
                flex-shrink: 0 !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
            }
            
            /* Icon - Tablet & Desktop */
            @media (min-width: 640px) {
                .swal-toast-responsive .swal2-icon {
                    margin: 6px auto 8px auto !important;
                    width: 1.8em !important;
                    height: 1.8em !important;
                }
            }
            
            @media (min-width: 1024px) {
                .swal-toast-responsive .swal2-icon {
                    margin: 8px auto 10px auto !important;
                    width: 2em !important;
                    height: 2em !important;
                }
            }
            
            /* Icon colors */
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
            }
            
            /* Progress bar */
            .swal-toast-responsive .swal2-timer-progress-bar {
                background: rgba(255, 255, 255, 0.3) !important;
                height: 3px !important;
            }
            
            /* Close button - Mobile */
            .swal-toast-responsive .swal2-close {
                color: rgba(255, 255, 255, 0.8) !important;
                font-size: 16px !important;
                width: 20px !important;
                height: 20px !important;
                line-height: 20px !important;
                right: 4px !important;
                top: 4px !important;
            }
            
            /* Close button - Desktop */
            @media (min-width: 1024px) {
                .swal-toast-responsive .swal2-close {
                    font-size: 20px !important;
                    width: 28px !important;
                    height: 28px !important;
                    line-height: 28px !important;
                    right: 8px !important;
                    top: 8px !important;
                }
            }
            
            .swal-toast-responsive .swal2-close:hover {
                color: #ffffff !important;
                transform: scale(1.1) !important;
            }
            
            /* Content wrapper alignment */
            .swal-toast-responsive .swal2-content {
                padding: 0 8px 8px 8px !important;
                margin: 0 !important;
                display: flex !important;
                flex-direction: column !important;
                align-items: flex-start !important;
                justify-content: center !important;
            }
            
            /* Content padding - Desktop */
            @media (min-width: 1024px) {
                .swal-toast-responsive .swal2-content {
                    padding: 0 12px 12px 12px !important;
                }
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
