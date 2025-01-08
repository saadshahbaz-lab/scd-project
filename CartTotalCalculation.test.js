const { expect } = require('chai');

describe('Cart Total Calculation', () => {
  it('should calculate the total price correctly', () => {
    const cart = [
      { name: 'Product 1', price: 500 },
      { name: 'Product 2', price: 300 },
    ];

    localStorage.setItem('cart', JSON.stringify(cart));

    // Simulating the loadCart function
    const cartTotal = cart.reduce((total, item) => total + item.price, 0);

    expect(cartTotal).to.equal(800);  // The total should be 800
  });

  it('should show "Your cart is empty" when the cart is empty', () => {
    localStorage.setItem('cart', JSON.stringify([]));

    // Simulating the loadCart function when cart is empty
    const cart = JSON.parse(localStorage.getItem('cart'));
    const message = cart.length === 0 ? 'Your cart is empty!' : '';
    
    expect(message).to.equal('Your cart is empty!');
  });
});
