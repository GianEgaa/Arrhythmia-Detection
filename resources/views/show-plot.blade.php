<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plot Images</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h1 {
            color: #333;
            margin-top: 20px;
        }

        .image-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            max-width: 1200px;
            margin: 20px auto;
        }

        .image-column {
            flex: 0 0 calc(33.33% - 20px);
            margin: 10px;
            text-align: center;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            max-width: 400px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .image-container img:hover {
            transform: scale(1.1);
        }

        .explanation-container {
            max-width: 1200px;
            margin: 20px auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .explanation-column {
            flex: 1;
            margin: 10px;
            text-align: left;
            max-width: 400px; 
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .explanation-column:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .explanation-column h2 {
            color: #000000;
            margin-bottom: 10px;
        }

        .explanation-column p {
            color: #444;
            line-height: 1.6;
        }

        #explanations {
            list-style-type: none;
            padding: 0;
            display: none; 
        }

        #explanations li {
            margin-bottom: 10px;
        }

        th, td {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Plot Images</h1>

    <div class="image-container">
        @foreach($images as $image)
            <div class="image-column">
                <a href="{{ asset('storage/'.$image) }}" class="image-link">
                    <img src="{{ asset('storage/'.$image) }}" alt="{{ $image }}">
                </a>
            </div>
        @endforeach
    </div>

    <div class="explanation-container">
        <div class="explanation-column">
            <h2>Time Domain</h2>
            <p>
                In signal processing, the time domain refers to the representation of signals in the time or temporal dimension. It provides insights into how a signal varies over time and is essential for understanding the behavior of signals in practical applications.
            </p>
        </div>
        <div class="explanation-column">
            <h2>Frequency Domain</h2>
            <p>
                Using PSD (Power Spectral Density) in creating frequency domain plots offers advantages by providing concentrated information about the distribution of signal energy across various frequency components. PSD plots enable observers to see the relative contribution of each frequency component to the overall signal and to differentiate between signals generated by specific frequency components.
            </p>
        </div>
    </div>

    <div class="container mt-5">
        <h1>Feature Extraction</h1>

        <div id="data-container" class="mt-3 d-flex justify-content-center"></div>

        <script>
            var dfData = {!! $feature !!};
            
            var tableHtml = '<table class="table table-bordered table-striped"><thead><tr>';
            
            for (var key in dfData[0]) {
                tableHtml += '<th scope="col">' + key + '</th>';
            }
            
            tableHtml += '</tr></thead><tbody>';
            
            for (var i = 0; i < dfData.length; i++) {
                tableHtml += '<tr>';
                
                for (var key in dfData[i]) {
                    if (typeof dfData[i][key] === 'number'){
                        var formattedNumber = dfData[i][key].toFixed(3);
                        tableHtml += '<td>' + formattedNumber + '</td>';
                        // tableHtml += '<td>' + dfData[i][key] + '</td>';
                    }else{
                        tableHtml += '<td>' + dfData[i][key] + '</td>';
                    }
                }
                tableHtml += '</tr>';
            }
            
            tableHtml += '</tbody></table>';
            
            document.getElementById('data-container').innerHTML = tableHtml;
        </script>
    </div>

    <div class="container mt-5">
        <button class="btn btn-primary mb-3" onclick="toggleExplanations()">Show/Hide Explanations</button>

        <ul id="explanations">
            <li><strong>meanRR:</strong> Mean of RR intervals (average time between successive heartbeats).</li>
            <li><strong>HR:</strong> Heart Rate (beats per minute).</li>
            <li><strong>SDRR:</strong> Standard deviation of RR intervals.</li>
            <li><strong>CVR:</strong> Coefficient of Variation of RR intervals (SDRR/meanRR).</li>
            <li><strong>RMSSD:</strong> Root Mean Square of Successive Differences (a measure of short-term HRV).</li>
            <li><strong>NN50:</strong> Number of pairs of successive RR intervals differing by more than 50 ms.</li>
            <li><strong>SDSD:</strong> Standard deviation of successive differences between RR intervals.</li>
            <li><strong>LF_Peak:</strong> Power in the Low-Frequency (LF) range.</li>
            <li><strong>HF_Peak:</strong> Power in the High-Frequency (HF) range.</li>
            <li><strong>LF_Norm:</strong> Normalized LF power.</li>
            <li><strong>HF_Norm:</strong> Normalized HF power.</li>
            <li><strong>LF/HF:</strong> Ratio of LF to HF power.</li>
            <li><strong>Label:</strong> Classification label or category.</li>
        </ul>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
    <script>
        function toggleExplanations() {
            var explanations = document.getElementById("explanations");
            explanations.style.display = (explanations.style.display === "none") ? "block" : "none";
        }

        $(document).ready(function() {
            $('.image-link').magnificPopup({
                type: 'image',
                closeOnContentClick: true,
                closeBtnInside: false,
                fixedContentPos: true,
                mainClass: 'mfp-no-margins mfp-with-zoom', 
                image: {
                    verticalFit: true
                },
                zoom: {
                    enabled: true,
                    duration: 300 
                }
            });
        });
    </script>
</body>
</html>
