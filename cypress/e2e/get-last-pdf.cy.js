describe('Récupération dernier PDF', () => {
  it('test 1 - récupération OK', () => {
    cy.visit('http://pdf-front-app.test/login');

    // Entrer le nom d'utilisateur et le mot de passe
    cy.get('#email').type('antoine@test.fr');
    cy.get('#password').type('azerty');

    // Soumettre le formulaire
    cy.get('button[type="submit"]').click();

    // Vérifier que l'utilisateur est connecté
      cy.contains('Accueil').should('exist');

      cy.visit('http://pdf-front-app.test/pricing');

      // get last offer class and click on it
      cy.get('.offer').last().click();

      cy.visit('http://pdf-front-app.test/generate-pdf');

      cy.get('#url').type('https://lairantoine.fr');

      cy.get('input[type="submit"]').click();

      cy.visit('http://pdf-front-app.test/profile');

      cy.get('.old-pdf').first().click();
  });
});