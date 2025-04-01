const emailValidation = (email: string): boolean => {
  const emailFormat = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailFormat.test(String(email).toLowerCase());
};

const phoneValidation = (number: string): boolean => {
  const phonePhone = /^(0)\d{10}$/;
  return phonePhone.test(number);
};

export { emailValidation, phoneValidation };
