@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<style>
    :root {
        --primary-color: #e1206b;
        --background-color: #ffffff;
        --text-color: #333;
    }

    body {
        background-color: var(--background-color);
        color: var(--text-color);
    }

    h2 {
        color: var(--primary-color);
    }

    .charts-row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 40px;
    }

    .chart-container {
        flex: 1 1 calc(33.33% - 20px);
        background-color: var(--background-color);
        border: 1px solid var(--primary-color);
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    canvas {
        width: 100% !important;
        height: auto !important;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 40px;
    }

    table, th, td {
        border: 1px solid var(--primary-color);
    }

    th {
        background-color: var(--primary-color);
        color: white;
        padding: 8px;
    }

    td {
        padding: 8px;
        text-align: center;
    }

    @media (max-width: 900px) {
        .chart-container {
            flex: 1 1 100%;
        }
    }
</style>

<h2>Welcome to the Dashboard</h2>
<p>This is the admin dashboard content.</p>

<div class="charts-row">
    <div class="chart-container">
        <canvas id="monthlySalesChart"></canvas>
    </div>

    <div class="chart-container">
        <canvas id="dailySalesChart"></canvas>
    </div>

    <div class="chart-container">
        <canvas id="totalCustomersChart"></canvas>
    </div>
</div>

<h3>Customer Details</h3>
<table>
    <thead>
        <tr>
            <th>Customer Name</th>
            <th>Email</th>
            <th>Joined Date</th>
            <th>Total Orders</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>John Doe</td>
            <td>john@example.com</td>
            <td>2024-01-15</td>
            <td>5</td>
        </tr>
        <tr>
            <td>Jane Smith</td>
            <td>jane@example.com</td>
            <td>2024-03-22</td>
            <td>3</td>
        </tr>
        <tr>
            <td>Robert Johnson</td>
            <td>robert@example.com</td>
            <td>2024-02-10</td>
            <td>7</td>
        </tr>
    </tbody>
</table>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const primaryColor = getComputedStyle(document.documentElement).getPropertyValue('--primary-color').trim();

        // Monthly Sales Chart
        const monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');
        new Chart(monthlySalesCtx, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May'],
                datasets: [{
                    label: 'Monthly Sales',
                    data: [12000, 15000, 10000, 17000, 14000],
                    backgroundColor: primaryColor
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Monthly Sales'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Daily Sales Chart
        const dailySalesCtx = document.getElementById('dailySalesChart').getContext('2d');
        new Chart(dailySalesCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Daily Sales',
                    data: [2000, 2500, 1800, 3000, 2200, 2800, 2600],
                    borderColor: primaryColor,
                    backgroundColor: primaryColor + '33',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Daily Sales'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Total Customers Chart
        const totalCustomersCtx = document.getElementById('totalCustomersChart').getContext('2d');
        new Chart(totalCustomersCtx, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May'],
                datasets: [{
                    label: 'Total Customers',
                    data: [50, 65, 80, 90, 120],
                    backgroundColor: primaryColor
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Total Customers (Month-wise)'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection

