<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Yii 2 Update Post</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script> -->

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- ChartDataLabels -->
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

    <style>
          /* CSS to ensure the chart container is appropriately sized */
        #chart-container {
            position: relative;
            height: 400px; /* Adjust height as needed */
            width: 100%;
        }
        #myBarChart {
            width: 100% !important;
            height: 100% !important;
            background: #F7F7F7;
        }
    </style>

</head>
<body>


<div class="container mt-2">
    <h2 class="mt-3">Update Post</h2>

    <div style="text-align: center;">
        <?= Html::a('PDF Generate', ['gen-pdf', 'id' => $posts->id], ['class' => 'btn btn-warning btn-sm', 'target' => '_blank']) ?>
    </div>


     <div class="mt-3" id="chart-container">
        <canvas id="myBarChart"></canvas>
    </div>

    <div class="body-content mt-3">
        <?php $form = ActiveForm::begin() ?> 

        <div class="form-group">
            <?= $form->field($posts, 'title')->textInput(['class' => 'form-control', 'placeholder' => 'Enter title'])->label('Title') ?>
        </div>

        <div class="form-group">
            <?= $form->field($posts, 'description')->textarea(['rows' => '4', 'class' => 'form-control', 'placeholder' => 'Enter description'])->label('Description') ?>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-lg-6">
                    <?php $items = ['CMS' => 'CMS', 'MVC'=>'MVC', 'e-commerce' =>'e-commerce']; ?>
                    <?= $form->field($posts, 'category')->dropDownList($items, ['prompt' => 'Select', 'class' => 'form-control'])->label('Category') ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-3">
                            <?= Html::submitButton('Update Post', ['class'=>'btn btn-success']); ?>
                        </div>
                        
                        <div class="col-lg-4">
                            <a href="<?= yii::$app->homeURL ?>" class="btn btn-primary">Go Back</a>
                        </div>

                        <div class="col-lg-4">
                            <?= Html::a('PDF', ['gen-pdf', 'id' => $posts->id], ['class' => 'btn btn-warning btn-sm', 'target' => '_blank']) ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>   
    </div>    
</div> 




    <!-- V highchart -->
    
    <script type="text/javascript">
        function calculateFontSize(chart) {
            const width = chart.width;
            const baseFontSize = 14; // Base font size
            const responsiveFontSize = Math.max(Math.min(width / 30, baseFontSize), 10);
            return responsiveFontSize;
        }

        const ctx = document.getElementById('myBarChart').getContext('2d');
        const myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    'Easy process of doing fund transfers', 
                    'Process is quick', 
                    '24x7, 365 days incl holidays', 
                    ['Knowing beneficiary / payee name', 'before making payment'] // Multiline label
                ],
                datasets: [{
                    label: '',
                    data: [80, 60, 40, 20], // Ensure these are numeric percentages
                    backgroundColor: 'rgba(71, 190, 213)',
                    barThickness: 30 // Adjust the bar thickness here if needed
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Ensure the chart uses the container's size
                layout: {
                    padding: {
                        top: 20,
                        bottom: 20,
                        left: 20,
                        right: 20
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false // Disable grid lines on the x-axis
                        },
                        ticks: {
                            autoSkip: false,
                            maxRotation: 0, // Rotate labels to fit better
                            minRotation: 0,
                            align: 'center' // Align labels to start of the tick
                        },
                        barPercentage: 0.4, // Adjust this value to increase or decrease the bar width (1.0 = full width, <1.0 = thinner bars)
                        categoryPercentage: 0.4 // Adjust this value to increase or decrease the space between bars
                    },
                    y: {
                        grid: {
                            display: false // Disable grid lines on the y-axis
                        },
                        display: false, // Enable the y-axis labels
                        beginAtZero: true, // Ensure the y-axis starts at zero
                        max: 100 // Set the maximum value of the y-axis to ensure all bars are visible
                    }
                },
                plugins: {
                    legend: {
                        display: false // Disable the legend
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.raw + '%'; // Ensure percentage is shown
                            }
                        }
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'end',
                        offset: 4, // Adjust if labels are too close to the bars
                        formatter: function(value) {
                            return value + '%';
                        },
                        color: 'black',
                        font: function(context) {
                            const chart = context.chart;
                            const fontSize = calculateFontSize(chart);
                            return {
                                size: fontSize,
                                weight: 'bold'
                            };
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    </script>



    <!-- Save Image by vikash highchart -->
    <script type="text/javascript">
      function sendChartToServer() {
         const canvas = document.getElementById('myBarChart');
         const image = canvas.toDataURL('image/png');
         console.log('Image Data:', image); // Log image data

         const xhr = new XMLHttpRequest();
         const csrfToken = '<?= Yii::$app->request->csrfToken ?>'; // Get CSRF token
         xhr.open('POST', '<?= Yii::$app->urlManager->createUrl('post/save-canvaschart') ?>', true);
         xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
         xhr.setRequestHeader('X-CSRF-Token', csrfToken); // Set CSRF token
         xhr.onreadystatechange = function () {
           if (xhr.readyState === XMLHttpRequest.DONE) {
             console.log('Server Response:', xhr.responseText); // Log server response
             //alert(xhr.responseText); // Debugging response
           }
         };
         xhr.send('image=' + encodeURIComponent(image) + '&_csrf=' + csrfToken);
      }

       // Ensure chart is rendered before sending data
       window.onload = function() {
         setTimeout(sendChartToServer, 1000); // Delay to ensure chart is rendered
       };
    </script>

</body>
</html>