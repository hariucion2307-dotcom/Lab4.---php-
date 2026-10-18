<?php
declare(strict_types=1); 
/**
 * Массив банковских транзакций. 
 */
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
        "date" => "2026-03-05",
        "amount" => 250.00,
        "description" => "Electricity bill",
        "merchant" => "Energy Company",  
    ],
    [
        "id" => 4,
        "date" => "2026-04-20",
        "amount" => 45.90,
        "description" => "Internet payment",
        "merchant" => "Moldtelecom",  
    ],
    [
         "id" => 5,
        "date" => "2026-05-19",
        "amount" => 320.00,
        "description" => "Clothes purchase",
        "merchant" => "Fashion Store",  
    ]
];
/**
 * Вычисляет общую сумму транзакций.
 * @param array $transactions Массив транзакций. 
 * @return float Общая сумма. 
 */  
function calculateTotalAmount(array $transactions): float 
{
    $total = 0.0;
    foreach ($transactions as $transaction) {
        $total += $transaction["amount"];
    }
    return $total;
} 
/**
 * Ищет транзакции по части описания. 
 * 
 * @param string $descriptionPart  Часть описания.
 * @return array Найденные транзакции. 
 */ 
function findTranscactionByDescription(string $descriptionPart): array 
{
    global $transactions;
    $result = [];
    foreach ($transactions as $transaction) {
        if (
            stripos(
                $transaction["description"],
                $descriptionPart
            ) !== false
        ) {
            $result[] = $transaction;
        } 
    }
    return $result;
} 
/**
 * Ищет транзакции по ID с помощью foreach.
 * 
 * @param int $id Идентификатор транзакции. 
 * @param array|null Найденная транзакция или null.
 */ 
function findTranscactionById(int $id): ?array 
{
    global $transactions;
    foreach ($transactions as $transaction) { 
        if ($transaction["id"] === $id) {
            return $transaction;
        }
    }
    return null;
} 
/**
 * Ищет транзакцию по ID с помощью array_filter.
 * 
 * @param int $id Идентификатор транзакции. 
 * @return array|null Найденная транзакция или null. 
 */ 
function findTranscactionByIdFilter(int $id): ?array 
{
    global $transactions;
    $result = array_filter(
        $transactions,
        fn(array $transaction): bool =>
        $transaction["id"] === $id 
    );
    return $result === [] ? null : reset($result);
} 
/**
 * Вычисляет количество дней с даты транзакции до сегодня. 
 * 
 * @param string $date Дата в формате YYYY-MM-DD. 
 * @return int Количество прошедших дней. 
 */ 
function daysSinceTransaction(string $date): int 
{
    $transactionDate = new DateTime($date);
    $currentDate = new DateTime("today");
    return (int) $transactionDate ->diff($currentDate)
    ->format("%r%a");
} 
/**
 * 
 * @param int $id Идентификатор. 
 * @param string $date Дата транзакции. 
 * @param float $amount Сумма. 
 * @param string $description Описание платежа. 
 * @param string $merchant Получатель платежа. 
 * @return void
 */ 
function addTransaction(
    int $id,
    string $date,
    float $amount,
    string $description,
    string $merchant
): void {
    global $transactions;
    foreach ($transactions as $transaction) {
        if ($transaction["id"] === $id) {
            return;
        }
    } 
    $transactions[] = [
        "id" => $id,
        "date" => $date,
        "amount" => $amount,
        "description" => $description,
        "merchant" => $merchant
    ];
} 
/**
 * Удаляем транзакции по ID.
 * @param int $id Идентификатор транзакции. 
 * @param void 
 */ 
function deleteTransaction(int $id): void 
{
    global $transactions;
    foreach ($transactions as $key => $transaction) {
        if ($transaction["id"] === $id) {
            unset ($transactions[$key]);
            break;
        } 
    } 
    $transactions = array_values($transactions);
} 
//Добавляем транзакцию.
addTransaction(
    6,
    "2026-06-18",
    120.00,
    "Payment for books",
    "Book Store"
);
// Удаляем транзакцию с ID 2. 
deleteTransaction(2);
//Сортируем по дате по возрастанию. 
$transactionsByDate = $transactions;
usort(
    $transactionsByDate,
    fn(array $a, array $b): int => $a["date"] <=> $b["date"]
);
//Сортируем по сумме по убыванию. 
$transactionsByAmount = $transactions; 
usort(
    $transactionsByAmount,
    fn(array $a, array $b): int => $b["amount"] <=> $a["amount"]
);
//Выполняем поиск. 
$searchResults = findTranscactionByDescription("Payment ");
$transactionById = findTranscactionById(3);
$transactionByIdFilter = findTranscactionByIdFilter(3);
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Банковские транзакции</title> 
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 30px;
                background: #f4f6f9;
                color: #222;
            } 
            h1, h2 {
                color: #243b53;
            } 
            table {
                width: 100%;
                border-collapse: collapse;
                background: white;
                margin-bottom: 30px;
            } 
            th, td {
                border: 1px solid #ccc;
                padding: 10px;
                text-align: left;
            }
            th {
                background: #dce6f1;
            } 
            tfoot {
                font-weight: bold;
                background: #e8f5e9; 
            } 
            .result {
                background: white;
                padding: 15px;
                margin-bottom: 20px;
            }
            </style>
            </head>
            <body>
                <h1>Система управления банковскими транзакциями</h1>
                <h2>1. Все транзакции</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Дата</th>
                            <th>Сумма</th>
                            <th>Описание</th>
                            <th>Организация</th>
                            <th>Количество дней</th>
</tr> 
</thead>
<tbody>
    <?php foreach ($transactions as $transaction): ?>
        <tr>
            <td><?=$transaction["id"] ?></td>
            <td><?=htmlspecialchars($transaction["date"]) ?></td>
            <td><?=number_format($transaction["amount"], 2) ?></td>
            <td><?=htmlspecialchars($transaction["description"]) ?></td>
            <td><?=htmlspecialchars($transaction["merchant"]) ?></td>
            <td><?=daysSinceTransaction($transaction["date"]) ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan = "2">Общая сумма:</td>
            <td colspan = "4"><?=number_format(calculateTotalAmount($transactions), 2) ?></td>
    </tr>
    </tfoot>
    </table>
    <h2>2. Сортировка по дате</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Дата</th>
                <th>Сумма</th>
                <th>Описание</th>
                <th>Организация</th>
    </tr>
    </thead>
    <tbody><?php foreach ($transactionsByDate as $transaction): ?>
        <tr>
            <td><?=$transaction["id"] ?></td>
            <td><?=htmlspecialchars($transaction["date"]) ?></td>
            <td><?=number_format($transaction["amount"], 2) ?></td>
            <td><?=htmlspecialchars($transaction["description"]) ?></td>
            <td><?=htmlspecialchars($transaction["merchant"]) ?></td>
            </tr>
    <?php endforeach; ?>
    </tbody>
    </table> 
    <h2>3. Сортировка по сумме (по убыванию)</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Дата</th>
                <th>Сумма</th>
                <th>Описание</th>
                <th>Организация</th>
    </tr>
    </thead>
    <tbody><?php foreach ($transactionsByAmount as $transaction): ?>
        <tr>
             <td><?=$transaction["id"] ?></td>
             <td><?=htmlspecialchars($transaction["date"]) ?></td>
             <td><?=number_format($transaction["amount"], 2) ?></td>
             <td><?=htmlspecialchars($transaction["description"]) ?></td>
             <td><?=htmlspecialchars($transaction["merchant"]) ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    </table>  
    <h2>4. Поиск по описанию: Payment</h2>
<div class="result">
    <?php if ($searchResults !== []): ?>
        <?php foreach ($searchResults as $transaction): ?>
            <p>
                ID: <?=$transaction["id"] ?> |
                <?=htmlspecialchars($transaction["description"]) ?> |
                <?=number_format($transaction["amount"], 2) ?> 
        </p> 
        <?php endforeach; ?>
        <?php else: ?>
            <p>Транзакции не найдены.</p>
            <?php endif; ?>
    </div>
    <h2>5. Поиск по ID через foreach</h2>
<div class="result">
    <?php if ($transactionById !== null): ?>
        <p>
            <?=htmlspecialchars($transactionById["description"]) ?>
            - <?=number_format($transactionById["amount"], 2) ?>
    </p>
    <?php else: ?>
        <p>Транзакция не найдена.</p>
        <?php endif; ?>
    </div>
    <h2>6. Поиск по ID через array_filter</h2>
    <div class="result"> 
        <?php if ($transactionByIdFilter !== null): ?>
            <p>
                <?=htmlspecialchars($transactionByIdFilter["description"]) ?>
                - <?=number_format($transactionByIdFilter["amount"], 2) ?>
        </p>
         <?php else: ?>
        <p>Транзакция не найдена.</p>
        <?php endif; ?>
    </div>
         </body>
         </html>


   

        




            

                




        
