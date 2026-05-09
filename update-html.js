const fs = require('fs');

let html = fs.readFileSync('index.html', 'utf8');

html = html.replace('<h3>Goodluck Igbokwe</h3>\n        <p>FullStack Developer</p>', '<h3 data-content-key="header_name">Goodluck Igbokwe</h3>\n        <p data-content-key="header_role">FullStack Developer</p>');

html = html.replace('<h3>Goodluck Igbokwe</h3>\n        <p>Junior Software Engineer</p>', '<h3 data-content-key="home_name">Goodluck Igbokwe</h3>\n        <p data-content-key="home_role">Junior Software Engineer</p>');

html = html.replace('<a href="./other_files/Goodluck-Igbokwe-Resume.pdf" class="btn">download CV</a>', '<a href="./other_files/Goodluck-Igbokwe-Resume.pdf" class="btn" data-content-key="home_resume_url">download CV</a>');

html = html.replace('<a href="https://www.linkedin.com/in/mantle-bearer" class="fab fa-linkedin-in"></a>', '<a href="https://www.linkedin.com/in/mantle-bearer" class="fab fa-linkedin-in" data-content-key="contact_linkedin"></a>');
html = html.replace('<a href="mailto:igbokwegoodluck8@gmail.com" class="fas fa-envelope"></a>', '<a href="mailto:igbokwegoodluck8@gmail.com" class="fas fa-envelope" data-content-key="contact_email"></a>');
html = html.replace('<a href="https://instagram.com/mantle_bearer?igshid=OGQ5ZDc2ODk2ZA==" class="fab fa-instagram"></a>', '<a href="https://instagram.com/mantle_bearer?igshid=OGQ5ZDc2ODk2ZA==" class="fab fa-instagram" data-content-key="contact_instagram"></a>');
html = html.replace('<a href="https://wa.link/p9709d" class="fab fa-whatsapp"></a>', '<a href="https://wa.link/p9709d" class="fab fa-whatsapp" data-content-key="contact_whatsapp"></a>');
html = html.replace('<a href="https://github.com/mantle-bearer" class="fab fa-github"></a>', '<a href="https://github.com/mantle-bearer" class="fab fa-github" data-content-key="contact_github"></a>');

html = html.replace('<h3>4+</h3>', '<h3 data-content-key="about_experience_years">4+</h3>');
html = html.replace('<h3>150+</h3>', '<h3 data-content-key="about_clients">150+</h3>');
html = html.replace('<h3>110+</h3>', '<h3 data-content-key="about_hours">110+</h3>');
html = html.replace('<h3>5+</h3>', '<h3 data-content-key="about_awards">5+</h3>');

html = html.replace('<p>Junior Full-stack Developer with 4 years of experience in backend and web development. Skilled in RESTful APIs, MySQL, PostgreSQL, and PHP frameworks like Laravel and WordPress. Passionate about building scalable applications, optimizing performance, and collaborating in teams while focusing on continuous learning and problem-solving</p>', '<p data-content-key="about_bio">Junior Full-stack Developer with 4 years of experience in backend and web development. Skilled in RESTful APIs, MySQL, PostgreSQL, and PHP frameworks like Laravel and WordPress. Passionate about building scalable applications, optimizing performance, and collaborating in teams while focusing on continuous learning and problem-solving</p>');

if (!html.includes('<script src="./hydrate.js"></script>')) {
  html = html.replace('</body>', '<script src="./hydrate.js"></script>\n</body>');
}

fs.writeFileSync('index.html', html);
