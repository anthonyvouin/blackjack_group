describe('Ecosia.org Demo', function() {
    this.tags = ['demo'];
  
    before(browser => browser.navigateTo('http://localhost:5173/signup'));
  
    it('Demo test Signup', function(browser) {
      browser
        .waitForElementVisible('body')
        // .assert.titleContains('Login')
        .assert.visible('input[name=username]')
        .setValue('input[name=username]', 'test20')
        .assert.visible('input[name=email]')
        .setValue('input[name=email]', 'test20@test.fr')
        .assert.visible('input[name=password]')
        .setValue('input[name=password]', '123456789')
        .click('button[type=submit]')
        // wait the navigation
        .pause(30000)
        .assert.urlContains('http://localhost:5173/')
        .assert.containsText('h1', 'Login')
    });
  
    after(browser => browser.end());
  });
  