<x-app-layout>
    <div class="w-8/12 mx-auto my-auto bg-gray-100 mt-12 rounded-md px-2 py-2">
        <form action="{{ route('posts.create.post') }}" method="POST">
            @csrf
            <div class="ml-8 px-2 py-3 flex">
                @if (auth()->check())
                @php
                $user = auth()->user();
                @endphp
                <img id="profileDropdownToggle" class="h-8 w-8 rounded-full"
                    src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('default.jpg') }}"
                    alt="Binsta logo">
                @endif
                <h3 class="ml-4 mt-1 font-semibold">{{ $user->username }}</h3>
                <button type="submit" class="ml-auto text-blue-500 font-semibold">Post</button>
            </div>
            <hr>

            <div class="ml-8 my-4">
                <label for="languageSelect" class="font-semibold">Select Language:</label>
                <select name="programming_language" id="languageSelect"
                    class="ml-2 border boder-gray-200 p-1 outline-none rounded-md">
                    <option value="php">PHP</option>
                    <option value="javascript">JavaScript</option>
                    <option value="python">Python</option>
                    <option value="css">CSS</option>
                    <option value="c">C</option>
                    <option value="cpp">C++</option>
                    <option value="csharp">C#</option>
                    <option value="java">Java</option>
                    <option value="typescript">TypeScript</option>
                </select>
            </div>

            <div class="ml-8 my-4">
                <label for="highlightOption" class="font-semibold">Highlight Option:</label>
                <select id="highlightOption" class="ml-2 border boder-gray-200 p-1 outline-none rounded-md">
                    <option value="all">Highlight All</option>
                    <option value="selected">Highlight Selected Language Only</option>
                </select>
            </div>

            <textarea name="code"
                class="border boder-gray-200 outline-none w-full max-h-48 px-1"
                id="codeInput" rows="10" cols="50"></textarea>
            <div id="codeOutput" class="overflow-x-auto overflow-y-auto max-h-48"></div>

            <div class="ml-8 my-4">
                <input type="text" name="caption" id="caption" placeholder="Write a caption..."
                    class="bg-gray-100 w-full h-full outline-none px-2">
            </div>
        </form>
    </div>

    <script>
        // Function to update code output based on selected options
        function updateCodeOutput() {
            var codeInput = document.getElementById('codeInput').value;
            var codeOutput = document.getElementById('codeOutput');
            
            // Get the selected language from the dropdown
            var selectedLanguage = document.getElementById('languageSelect').value;
            
            // Get the selected highlight option from the dropdown
            var highlightOption = document.getElementById('highlightOption').value;
    
            // Use Prism.js to highlight the code based on the selected option
            if (highlightOption === 'all') {
                codeOutput.innerHTML = '<pre><code class="language-' + selectedLanguage + '">' + Prism.highlight(codeInput, Prism.languages[selectedLanguage], selectedLanguage) + '</code></pre>';
            } else {
                codeOutput.innerHTML = '<pre><code class="language-' + selectedLanguage + '">' + codeInput + '</code></pre>';
            }
            
            // Manually re-highlight to apply changes
            Prism.highlightAll();
        }

        // Add event listeners to the dropdowns
        document.getElementById('languageSelect').addEventListener('change', updateCodeOutput);
        document.getElementById('highlightOption').addEventListener('change', updateCodeOutput);
        document.getElementById('codeInput').addEventListener('input', updateCodeOutput);

        // Initial call to update the code output
        updateCodeOutput();
    </script>
</x-app-layout>