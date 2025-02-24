const emailValidation = (email: string): boolean => {
  const emailFormat = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailFormat.test(String(email).toLowerCase());
};
export { emailValidation };
