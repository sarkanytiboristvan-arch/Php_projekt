// Main JavaScript for Fitness Tracker

// Simple form validation
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });

    // Chart.js initialization if charts exist
    if (typeof chartData !== 'undefined') {
        const weightChartCanvas = document.getElementById('weightChart');
        if (weightChartCanvas && chartData.dates.length > 0) {
            const ctx = weightChartCanvas.getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.dates,
                    datasets: [{
                        label: 'Súly (kg)',
                        data: chartData.weight,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true
                        }
                    }
                }
            });
        }

        const bodyFatChartCanvas = document.getElementById('bodyFatChart');
        if (bodyFatChartCanvas && chartData.dates.length > 0) {
            const ctx = bodyFatChartCanvas.getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.dates,
                    datasets: [{
                        label: 'Testzsír %',
                        data: chartData.bodyFat,
                        borderColor: 'rgb(255, 99, 132)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true
                        }
                    }
                }
            });
        }
    }
});
