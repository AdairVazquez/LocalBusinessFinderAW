
// Obtener el contexto del canvas donde dibujaremos la gráfica de barras
const ctx = document.getElementById('myChart').getContext('2d');

// Extraer las etiquetas y datos de visitas para el gráfico de barras
const labels = Object.keys(visitasPorMes);  // Meses
const dataValues = Object.values(visitasPorMes);  // Número de visitas

// Crear el gráfico de barras
const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Visitas por mes',
            data: dataValues,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
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

const ctx2 = document.getElementById('myPieChart').getContext('2d');

// Datos de las calificaciones pasadas desde Laravel

console.log(estrellas);
// Crear el gráfico de pastel
const myPieChart = new Chart(ctx2, {
    type: 'pie', // Tipo de gráfico: pastel
    data: {
        labels: ['1 estrella', '2 estrellas', '3 estrellas', '4 estrellas', '5 estrellas'], // Etiquetas para las porciones
        datasets: [{
            label: 'Calificaciones de estrellas',
            data: [estrellas[1], estrellas[2], estrellas[3], estrellas[4], estrellas[5]], // Datos (valores para cada porción del pastel)
            backgroundColor: [
                'rgba(255, 99, 132, 0.6)',  // Rojo
                'rgba(54, 162, 235, 0.6)',  // Azul
                'rgba(255, 206, 86, 0.6)',  // Amarillo
                'rgba(75, 192, 192, 0.6)',  // Verde
                'rgba(153, 102, 255, 0.6)'  // Púrpura
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',   // Rojo
                'rgba(54, 162, 235, 1)',   // Azul
                'rgba(255, 206, 86, 1)',   // Amarillo
                'rgba(75, 192, 192, 1)',   // Verde
                'rgba(153, 102, 255, 1)'   // Púrpura
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,  // Hace el gráfico responsivo
        plugins: {
            legend: {
                position: 'top', // Posición de la leyenda
            },
            tooltip: {
                enabled: true // Habilitar los tooltips (información emergente)
            }
        }
    }
});


function toggleSidebar() {
    const sidebar = document.getElementById('mySidebar');
    if (sidebar.style.width === '300px') {
        sidebar.style.width = '0'; // Ocultar la barra lateral
    } else {
        sidebar.style.width = '250px'; // Mostrar la barra lateral
    }
}