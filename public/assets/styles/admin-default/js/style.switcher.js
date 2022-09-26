// Theme Switcher
function setTheme(styleName){
    localStorage.setItem('data-layout-mode', styleName);
    document.documentElement.setAttribute("data-layout-mode", styleName)
}
// function to toggle between light and dark theme
function toggleTheme() {
    let iconTheme = document.getElementById("icon-switcher");
    let getDefault = document.documentElement.getAttribute("data-layout-mode");
    if (localStorage.getItem('data-layout-mode') === 'dark' || getDefault === 'dark-forced'){
        iconTheme.classList.replace('icofont-sun-alt','icofont-night');
        setTheme('light');
    } else {
        iconTheme.classList.replace('icofont-night','icofont-sun-alt');
        setTheme('dark');
    }
}
// Immediately invoked function to set the theme on initial load
(function () {
    let iconTheme = document.getElementById("theme-switcher");
    let getDefault = document.documentElement.getAttribute("data-layout-mode");
    if(getDefault === 'dark-forced'){
        document.documentElement.setAttribute("data-layout-mode", "dark-forced");
        iconTheme.innerHTML = "<i id=\"icon-switcher\" class=\"icofont-sun-alt\"></i>";
    } else {
        if (localStorage.getItem('data-layout-mode') === 'dark') {
            iconTheme.innerHTML = "<i id=\"icon-switcher\" class=\"icofont-sun-alt\"></i>";
            setTheme('dark');
        } else {
            iconTheme.innerHTML = "<i id=\"icon-switcher\" class=\"icofont-night\"></i>";
            setTheme('light');
        }
    }
})();


