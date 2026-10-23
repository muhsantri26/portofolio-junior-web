export const tambah = (a, b) => a + b;
export function bagi(a, b) {
  if (b === 0) throw new Error("Pembagi tidak boleh nol");
  return a / b;
}
