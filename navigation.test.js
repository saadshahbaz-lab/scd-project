const puppeteer = require('puppeteer');
const { expect } = require('chai');

describe('Navigation Tests', () => {
  let browser;
  let page;

  before(async () => {
    browser = await puppeteer.launch();
    page = await browser.newPage();
    await page.goto('file:///path/to/your/homepage.html'); // Adjust path
  });

  after(async () => {
    await browser.close();
  });

  it('should navigate to the Contact Us page', async () => {
    await page.click('a[href="contact.html"]'); // Simulate click
    const url = await page.url();
    expect(url).to.include('contact.html'); // Check the URL
  });
});