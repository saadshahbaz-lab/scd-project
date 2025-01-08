const { expect } = require('chai');

describe('Remove Item from Cart', () => {
  it('should remove an item from the cart', () => {
    const cart = [
      { name: 'Product 1', price: 500 },
      { name: 'Product 2', price: 300 },
    ];

    // Simulating removing Product 1 from the cart
    cart.splice(0, 1); // Removing the first item (Product 1)

    localStorage.setItem('cart', JSON.stringify(cart));

    const updatedCart = JSON.parse(localStorage.getItem('cart'));

    expect(updatedCart.length).to.equal(1); // There should be 1 item left in the cart
    expect(updatedCart[0].name).to.equal('Product 2'); // Product 2 should be the only one remaining
  });
});
