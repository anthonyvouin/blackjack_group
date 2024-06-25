describe('Signup & Login Demo', function() {
    this.tags = ['demo'];
    const username = 'test35';
    const email = 'test35@test.fr';
    const password = '123456789';
    before(browser => browser.navigateTo('http://localhost:5173/signup'));
  
    it('Signup and login', function(browser) {
      browser
      .waitForElementVisible('body')
      // .assert.titleContains('Login')
      .assert.visible('input[name=username]')
      .setValue('input[name=username]', username)
      .assert.visible('input[name=email]')
      .setValue('input[name=email]', email)
      .assert.visible('input[name=password]')
      .setValue('input[name=password]', password)
      .click('button[type=submit]')
      // wait the navigation
      .pause(30000)
      .assert.urlContains('http://localhost:5173/')
      .assert.containsText('h1', 'Login')
      .waitForElementVisible('body')
        // .assert.titleContains('Login')
        .assert.visible('input[name=username]')
        .setValue('input[name=username]', username)
        .assert.visible('input[name=password]')
        .setValue('input[name=password]', password)
        .click('button[type=submit]')
        // wait the navigation
        .pause(30000)
        .assert.urlContains('http://localhost:5173/user/profile')
        .assert.containsText('h1', `Welcome ${username} !`)
    });
  
    after(browser => browser.end());
    
  });
  