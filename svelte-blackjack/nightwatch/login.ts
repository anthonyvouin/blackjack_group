describe('Ecosia.org Demo', function() {
    this.tags = ['demo'];
  
    before(browser => browser.navigateTo('http://localhost:5173/'));
  
    it('Demo test Login', function(browser) {
      browser
        .waitForElementVisible('body')
        // .assert.titleContains('Login')
        .assert.visible('input[name=username]')
        .setValue('input[name=username]', 'admin')
        .assert.visible('input[name=password]')
        .setValue('input[name=password]', 'admin')
        .click('button[type=submit]')
        // wait the navigation
        .pause(30000)
        .assert.urlContains('http://localhost:5173/user/profile')
        .assert.containsText('h1', 'Welcome admin !')
    });
  
    after(browser => browser.end());
  });
  