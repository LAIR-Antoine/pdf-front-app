describe('Formulaire d\'inscription', () => {
    it('test 1 - connexion OK', () => {
      cy.visit('http://pdf-front-app.test/signup');
  
      // Entrer le nom d'utilisateur et le mot de passe

      
      cy.get('#registration_firstname').type('Antoine');
      cy.get('#registration_lastname').type('Lair');
      cy.get('#registration_email').type('lair@test.fr');
      cy.get('#registration_plainPassword_first').type('azerty');
      cy.get('#registration_plainPassword_second').type('azerty');
  
      // Soumettre le formulaire
      cy.get('button[type="submit"]').click();
  
      // Vérifier que l'utilisateur est connecté
        cy.contains('Se connecter').should('exist');
    });
  });