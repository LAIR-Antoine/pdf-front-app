describe('Formulaire de Connexion', () => {
    it('test 1 - connexion OK', () => {
      cy.visit('http://pdf-front-app.test/login');
  
      // Entrer le nom d'utilisateur et le mot de passe
      cy.get('#email').type('antoine@test.fr');
      cy.get('#password').type('azerty');
  
      // Soumettre le formulaire
      cy.get('button[type="submit"]').click();
  
      // Vérifier que l'utilisateur est connecté
        cy.contains('Accueil').should('exist');
    });
  
    it('test 2 - connexion KO', () => {
      cy.visit('http://pdf-front-app.test/login');
  
      // Entrer un nom d'utilisateur et un mot de passe incorrects
      cy.get('#email').type('antoine@test.fr');
      cy.get('#password').type('qwerty');
  
      // Soumettre le formulaire
      cy.get('button[type="submit"]').click();
  
      // Vérifier que le message d'erreur est affiché
      cy.contains('Invalid credentials.').should('exist');
    });
  });