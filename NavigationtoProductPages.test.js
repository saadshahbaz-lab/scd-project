const puppeteer = require('puppeteer');
const { expect } = require('chai');

describe('Navigation to Product Pages', () => {
  let browser;
  let page;

  before(async () => {
    browser = await puppeteer.launch();
    page = await browser.newPage();
    await page.goto('file:///path/to/your/mainpage.html'); // Adjust path
  });

  after(async () => {
    await browser.close();
  });

  it('should navigate to Cloths page', async () => {
    await page.click('a[href="cloths.html"]');
    const url = await page.url();
    expect(url).to.include('cloths.html');
  });

  it('should navigate to Watches page', async () => {
    await page.click('a[href="watches.html"]');
    const url = await page.url();
    expect(url).to.include('watches.html');
  });

  it('should navigate to Perfumes page', async () => {
    await page.click('a[href="perfumes.html"]');
    const url = await page.url();
    expect(url).to.include('perfumes.html');
  });
});
