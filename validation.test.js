const { expect } = require('chai');
const { validateEmail, validatePassword } = require('../validation');

describe('Validation Tests', () => {
  it('should validate correct email format', () => {
    expect(validateEmail('test@example.com')).to.be.true;
    expect(validateEmail('invalid-email')).to.be.false;
  });

  it('should validate password strength', () => {
    expect(validatePassword('Strong@123')).to.be.true; // Valid password
    expect(validatePassword('weak')).to.be.false;      // Too short
    expect(validatePassword('NoSpecial123')).to.be.false; // Missing special character
  });
});
﻿
