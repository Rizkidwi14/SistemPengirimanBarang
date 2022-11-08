var pengiriman = document.getElementById("chartPengiriman");
var BarChart = new Chart(pengiriman,{
    type: 'bar',
    data:{
        labels: [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
        ],
        datasets: [{
            label: 'Jumlah Pengiriman',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: [0, 10, 5, 2, 20, 15],
        }],
    }
});
