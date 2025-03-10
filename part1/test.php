<?php

declare(strict_types=1);

$transactions = [
    [
        "id" => 1,
        "date" => "2019-01-01",
        "amount" => 100.00,
        "description" => "Payment for groceries",
        "merchant" => "SuperMart",
    ],
    [
        "id" => 2,
        "date" => "2020-02-15",
        "amount" => 75.50,
        "description" => "Dinner with friends",
        "merchant" => "Local Restaurant",
    ],
    [
        "id" => 3,
        "date" => "2023-06-10",
        "amount" => 200.75,
        "description" => "Online purchase",
        "merchant" => "Amazon",
    ],
];

function calculateTotalAmount(array $transactions): float {
    $total = 0;
    foreach ($transactions as $transaction) {
        $total += $transaction['amount'];
    }
    return $total;
}

function findTransactionByDescription(string $descriptionPart, array $transactions): array {
    return array_filter($transactions, function ($transaction) use ($descriptionPart) {
        return stripos($transaction['description'], $descriptionPart) !== false;
    });
}

function findTransactionByIdFilter(int $id, array $transactions): ?array {
    $result = array_filter($transactions, fn($transaction) => $transaction['id'] === $id);
    return !empty($result) ? array_values($result)[0] : null;
}

function daysSinceTransaction(string $date): int {
    $transactionDate = new DateTime($date); // Преобразуем строку в объект DateTime
    $currentDate = new DateTime(); // Текущая дата
    $interval = $transactionDate->diff($currentDate); // Разница между датами
    return $interval->days; // Возвращаем количество дней
}

function addTransaction(int $id, string $date, float $amount, string $description, string $merchant): void {
    global $transactions; // Обращаемся к глобальной переменной

    // Создаем новый элемент транзакции
    $newTransaction = [
        "id" => $id,
        "date" => $date,
        "amount" => $amount,
        "description" => $description,
        "merchant" => $merchant,
    ];

    // Добавляем транзакцию в массив
    $transactions[] = $newTransaction;
}

addTransaction(4, "2025-03-10", 150.00, "Purchase of new shoes", "ShoeStore");

function sortTransactionsByDate(array &$transactions): void {
    usort($transactions, function($a, $b) {
        $dateA = new DateTime($a['date']);
        $dateB = new DateTime($b['date']);
        return $dateA <=> $dateB; // Сортировка по дате (по возрастанию)
    });
}

function sortTransactionsByAmountDesc(array &$transactions): void {
    usort($transactions, function($a, $b) {
        return $b['amount'] <=> $a['amount']; // Сортировка по сумме (по убыванию)
    });
}




function testFindTransactions() { // additional, just for checking for mistakes 
    echo "<h3>Search by Description ('Dinner')</h3>";
    $foundTransactions = findTransactionByDescription("Dinner", $transactions);
    echo "<pre>" . print_r($foundTransactions, true) . "</pre>";

    echo "<h3>Search by ID (2) - array_filter</h3>";
    $foundTransaction2 = findTransactionByIdFilter(2, $transactions);
    echo "<pre>" . print_r($foundTransaction2, true) . "</pre>";
}

testFindTransactions();
function testSortings(){
    // Сортировка транзакций по дате
    sortTransactionsByDate($transactions);
    echo "<h3>Transactions Sorted by Date</h3>";
    echo "<pre>" . print_r($transactions, true) . "</pre>";

    // Сортировка транзакций по сумме (по убыванию)
    sortTransactionsByAmountDesc($transactions);
    echo "<h3>Transactions Sorted by Amount (Descending)</h3>";
    echo "<pre>" . print_r($transactions, true) . "</pre>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Bank Transactions</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Description</th>
            <th>Merchant</th>
            <th>Days Since</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($transactions as $transaction): ?>
            <tr>
                <td><?= $transaction['id'] ?></td>
                <td><?= $transaction['date'] ?></td>
                <td><?= number_format($transaction['amount'], 2) ?> USD</td>
                <td><?= htmlspecialchars($transaction['description']) ?></td>
                <td><?= htmlspecialchars($transaction['merchant']) ?></td>
                <td><?= daysSinceTransaction($transaction['date']) ?> days</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2"><strong>Total:</strong></td>
            <td><strong><?= number_format(calculateTotalAmount($transactions), 2) ?> USD</strong></td>
            <td colspan="3"></td>
        </tr>
    </tfoot>
</table>

</body>
</html>
