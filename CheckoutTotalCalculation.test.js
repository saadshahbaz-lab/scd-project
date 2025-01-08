const { expect } = require('chai');
const { getCartTotal } = require('../checkout'); // Assuming the function is in checkout.js

describe('Checkout Total Calculation', () => {
  it('should calculate total amount including delivery fee', () => {
    localStorage.setItem('cartTotal', 800); // Simulating a cart total of 800

    const totalAmount = getCartTotal();

    expect(totalAmount).to.equal(1000);  // 800 + 200 (delivery fee) = 1000
  });

  it('should default to delivery fee if cartTotal is invalid', () => {
    localStorage.setItem('cartTotal', 'invalid'); // Simulating an invalid cart total

    const totalAmount = getCartTotal();

    expect(totalAmount).to.equal(200);  // Only delivery fee
  });
});
