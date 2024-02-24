<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material Report</title>
    <!-- Подключаем библиотеку для создания графиков -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Material Report</h1>
    <div>
        <!-- Фильтр по имени автора -->
        <label for="authorFilter">Filter by Author:</label>
        <select id="authorFilter">
            <option value="">All</option>
            <!-- Выводим список авторов -->
            <?php foreach ($authors as $author): ?>
                <option value="<?= json_encode(array_column($data["materials"], "name")) ?>"><?php echo array_column($data["materials"], "name"); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <!-- Гистограмма -->
    <div>
        <canvas id="barChart"></canvas>
    </div>

    <script>
        // Получаем данные о материалах из PHP
        const materials = <?= json_encode(array_column($data["materials"], "name"))?>

        // Находим canvas элемент
        const ctx = document.getElementById('barChart').getContext('2d');

        // Функция для отображения гистограммы
        function displayBarChart(data) {
            const labels = data.map(item => item.title);
            const counts = data.map(item => item.count);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Material Count',
                        data: counts,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Инициализация гистограммы
        displayBarChart(materials);

        // Фильтрация по имени автора
        document.getElementById('authorFilter').addEventListener('change', function() {
            const selectedAuthor = this.value;
            let filteredMaterials = materials;

            if (selectedAuthor) {
                filteredMaterials = materials.filter(item => item.authors.includes(selectedAuthor));
            }

            // Перерисовываем гистограмму с отфильтрованными данными
            displayBarChart(filteredMaterials);
        });
    </script>
</body>
</html>
