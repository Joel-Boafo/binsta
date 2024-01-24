function updateCodeOutput() {
    var codeInput = document.getElementById('codeInput').value;
    var codeOutput = document.getElementById('codeOutput');
    
    var selectedLanguage = document.getElementById('languageSelect').value;
    
    var highlightOption = document.getElementById('highlightOption').value;

    if (highlightOption === 'all') {
        codeOutput.innerHTML = '<pre><code class="language-' + selectedLanguage + '">' + Prism.highlight(codeInput, Prism.languages[selectedLanguage], selectedLanguage) + '</code></pre>';
    } else {
        codeOutput.innerHTML = '<pre><code class="language-' + selectedLanguage + '">' + codeInput + '</code></pre>';
    }
    
    Prism.highlightAll();
}

document.getElementById('languageSelect').addEventListener('change', updateCodeOutput);
document.getElementById('highlightOption').addEventListener('change', updateCodeOutput);
document.getElementById('codeInput').addEventListener('input', updateCodeOutput);

updateCodeOutput();