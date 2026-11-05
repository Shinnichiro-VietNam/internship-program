export function formatPrice(amount: number): string {
  return `${new Intl.NumberFormat('vi-VN').format(amount)}đ`;
}
