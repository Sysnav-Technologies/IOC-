// Global configuration for IOC application
window.IOC_Config = {
    // Auto-detect base URL
    baseUrl: (function() {
        var protocol = window.location.protocol;
        var host = window.location.host;
        
        if (host === 'localhost' || host === '127.0.0.1' || host.includes(':')) {
            // Local environment - include /IOC/ in path
            return protocol + '//' + host + '/IOC/';
        } else {
            // Production environment - domain root
            return protocol + '//' + host + '/';
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



