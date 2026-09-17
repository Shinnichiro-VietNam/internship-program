export function formatCurrency(amount: number) {
    return new Intl.NumberFormat("ja-JP", {
        style: "currency",
        currency: "JPY",
    }).format(amount);
}