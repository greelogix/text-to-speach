<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Text to Speech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Text to Speech Converter</h2>
        <div class="card p-4">
            <div class="mb-3">
                <label for="text" class="form-label">Enter Text:</label>
                <textarea id="text" class="form-control  shaddow-none" rows="3" placeholder="Type text here..."></textarea>
            </div>
            <div class="mb-3">
                <label for="lang" class="form-label">Select Language:</label>
                <select  class="form-select lang">
                    <option value="en">English</option>
                    <option value="ur">Urdu</option>
                    <option value="es">Spanish</option>
                    <option value="fr">French</option>
                    <option value="de">German</option>
                </select>
            </div>
            <button class="btn btn-primary w-100" id="convertBtn">Convert to Speech</button>
            <div class="mt-3" id="audio-container" style="display: none;">
                <audio id="audio" controls class="w-100"></audio>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#convertBtn").click(function () {
                let text = $("#text").val().trim();
                let lang = $(".lang").val();
    
                if (text === "") {
                    alert("Please enter text");
                    return;
                }
    
                $.ajax({
                    url: "/api/generate-speech",
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({ text: text, lang: lang }),
                    success: function (data) {
                        if (data.status === "success") {
                            $("#audio").attr("src", data.audio_url);
                            $("#audio-container").show();
                            $("#audio")[0].play();
                        } else {
                            alert("Failed to generate speech");
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error:", error);
                        alert("Something went wrong!");
                    }
                });
            });
        });
    </script>
    
</body>
</html>
