export function initializeTheme() {
    const themes = {
        dark: {
            bg: '#0a0b1e',
            surface: '#161830',
            hover: '#1c1f3a'
        },
        light: {
            bg: '#f8f9fa',
            surface: '#ffffff',
            hover: '#e9ecef'
        }
    };
    
    function setTheme(theme) {
        document.documentElement.style.setProperty('--bg-color', themes[theme].bg);
        document.documentElement.style.setProperty('--surface-color', themes[theme].surface);
        document.documentElement.style.setProperty('--hover-color', themes[theme].hover);
        localStorage.setItem('theme', theme);
    }
    
    const savedTheme = localStorage.getItem('theme') || 'dark';
    setTheme(savedTheme);
}