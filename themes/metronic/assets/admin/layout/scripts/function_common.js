
function getPersonalTax(amount) {
    var tax = 0;
    amount -= 3500;
    if (amount <= 0)
        return 0;
    switch (true) {
        case amount <= 1500 :
            tax = 3;
            $base = 0;
            break;
        case amount > 1500 && amount <= 4500 :
            tax = 10;
            $base = 105;
            break;
        case amount > 4500 && amount <= 9000 :
            tax = 20;
            $base = 555;
            break;
        case amount > 9000 && amount <= 35000 :
            tax = 25;
            $base = 1005;
            break;
        case amount > 35000 && amount <= 55000 :
            tax = 30;
            $base = 2755;
            break;
        case amount > 55000 && amount <= 80000 :
            tax = 35;
            $base = 5505;
            break;
        case amount > 80000 :
            tax = 45;
            $base = 13505;
            break;
        default:
            return 0;
    }

    return Math.round((amount * tax / 100 - $base) * 100) / 100;
}
