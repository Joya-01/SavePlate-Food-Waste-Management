<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Smart Chef - SAVE Plate</title>
    
    <link rel="stylesheet" href="home.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    
    <style>
        /* Reusing your site's style */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('img/p11.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }

        /* Navbar Styles (Consistent with your other pages) */
        header {
            background: rgba(255, 255, 255, 0.95);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 50px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky; top: 0; z-index: 1000;
        }
        .logo { font-size: 24px; font-weight: 700; color: #333; }
        .nav-bar ul { display: flex; list-style: none; gap: 30px; }
        .nav-bar ul li a { text-decoration: none; color: #333; font-weight: 500; transition: 0.3s; }
        .nav-bar ul li a:hover, .nav-bar ul li a.active { color: #004AAD; }

        /* Main AI Section */
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }

        .chef-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            text-align: center;
        }

        h1 { color: #004AAD; margin-bottom: 10px; font-weight: 700; }
        p.sub-text { color: #666; margin-bottom: 30px; }

        /* Input Area */
        .input-group { position: relative; margin-bottom: 20px; }
        
        textarea {
            width: 100%;
            height: 100px;
            padding: 15px;
            border: 2px solid #eee;
            border-radius: 15px;
            font-size: 16px;
            resize: none;
            outline: none;
            transition: 0.3s;
            background: #f9f9f9;
        }
        textarea:focus { border-color: #004AAD; background: white; }

        button.btn-generate {
            background: linear-gradient(45deg, #004AAD, #007bff);
            color: white;
            border: none;
            padding: 15px 40px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 5px 15px rgba(0, 74, 173, 0.3);
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0 auto;
        }
        button.btn-generate:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0, 74, 173, 0.4); }

        /* Result Area */
        #result-area {
            margin-top: 30px;
            text-align: left;
            display: none; /* Hidden by default */
            border-top: 1px solid #eee;
            padding-top: 20px;
            animation: fadeIn 0.5s ease;
        }

        .recipe-content {
            background: #f0f7ff;
            padding: 20px;
            border-radius: 15px;
            color: #333;
            line-height: 1.8;
            white-space: pre-line; /* Keeps formatting */
        }

        /* Loading Spinner */
        .loader {
            display: none;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #004AAD;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }

        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>

    <header>
        <div class="logo">SAVE <b style="color: #004AAD;">Plate</b></div>
        <nav class="nav-bar">
            <ul>
                <li><a href="home.html">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="deals.php" style="color: #ff4d4d; font-weight: bold;">⚡ Deals</a></li>
                <li><a href="recipe.php" class="active" style="color: #28a745; font-weight: bold;">🧑‍🍳 AI Chef</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="chef-card">
            <i class="fa-solid fa-utensils" style="font-size: 50px; color: #004AAD; margin-bottom: 20px;"></i>
            <h1>AI Smart Chef</h1>
            <p class="sub-text">Don't throw it away! Tell us what ingredients you have, and our AI will generate a delicious recipe for you.</p>

            <div class="input-group">
                <textarea id="ingredients" placeholder="e.g., 2 tomatoes, some leftover rice, 1 egg, half an onion..."></textarea>
            </div>

            <button class="btn-generate" onclick="generateRecipe()">
                <i class="fa-solid fa-wand-magic-sparkles"></i> Generate Recipe
            </button>

            <div class="loader" id="loader"></div>

            <div id="result-area">
                <h3 style="color: #004AAD; margin-bottom: 10px;"><i class="fa-solid fa-scroll"></i> Your Recipe:</h3>
                <div class="recipe-content" id="recipe-text"></div>
            </div>
        </div>
    </div>

    <script>
    async function generateRecipe() {
        const ingredients = document.getElementById('ingredients').value;
        const resultArea = document.getElementById('result-area');
        const recipeText = document.getElementById('recipe-text');
        const loader = document.getElementById('loader');
        const btn = document.querySelector('.btn-generate');

        if (ingredients.trim() === "") {
            alert("Please enter some ingredients first!");
            return;
        }

        btn.disabled = true;
        btn.style.opacity = "0.7";
        loader.style.display = "block";
        resultArea.style.display = "none";

        // IMPORTANT: Replace the text below with your actual API key from Google AI Studio
        const apiKey = "AIzaSyA0ST23E2LBW-5AT5ucrl-7o9fE-rgXEFw"; 
        
        const prompt = `I have these leftover ingredients: ${ingredients}. Create a creative and tasty recipe using these to reduce food waste. Give it a catchy title, list of ingredients, and step-by-step instructions. Keep formatting clean.`;
        const url = `https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash:generateContent?key=${apiKey}`;

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    contents: [{ parts: [{ text: prompt }] }]
                })
            });

            const data = await response.json();

            // Handling the 400 error from your screenshot
            if (!response.ok) {
                if (response.status === 400) {
                    throw new Error("Invalid API Key. Please make sure you replaced 'PASTE_YOUR_REAL_KEY_HERE' with your actual key.");
                }
                throw new Error(data.error ? data.error.message : "API Error");
            }
            
            if (data.candidates && data.candidates[0].content.parts[0].text) {
                const aiResponse = data.candidates[0].content.parts[0].text;
                // Formats **text** into bold
                let formattedText = aiResponse.replace(/\*\*(.*?)\*\*/g, '<b>$1</b>');
                recipeText.innerHTML = formattedText;
                resultArea.style.display = "block";
            }

        } catch (error) {
            console.error("Error:", error);
            alert(error.message);
        } finally {
            loader.style.display = "none";
            btn.disabled = false;
            btn.style.opacity = "1";
        }
    }
</script>

</body>
</html>