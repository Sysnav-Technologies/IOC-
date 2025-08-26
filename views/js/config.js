// Global configuration for IOC application
window.IOC_Config = {
    // Auto-detect base URL
    baseUrl: (function() {
        var protocol = window.location.protocol;
        var host = window.location.host;
        var pathname = window.location.pathname;
        
        if (host === 'localhost' || host === '127.0.0.1' || host.includes(':')) {
            // Local environment - include /IOC/ in path
            return protocol + '//' + host + '/IOC/';
        } else {
            // Production environment - auto-detect from current path
            var pathParts = pathname.split('/');
            var basePath = '/';
            
            // If we're in a subdirectory, include it
            if (pathParts.length > 2 && pathParts[1] !== 'index.php') {
                basePath = '/' + pathParts[1] + '/';
            }
            
            return protocol + '//' + host + basePath;
        }
    })(),
    
    // Helper function to build URLs
    url: function(path) {
        return this.baseUrl + (path.startsWith('/') ? path.substring(1) : path);
    }
};

// Global utility functions
function buildUrl(path) {
    return IOC_Config.url(path);
}

// Log configuration for debugging (remove in production)
console.log('IOC Config loaded:', window.IOC_Config);



