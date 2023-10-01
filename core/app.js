const express = require('express');
const phpExpress = require('php-express')({
    binPath: 'php'
});
const port = 3000;
const app = express();

app.set('views', './app/views');
app.engine('php', phpExpress.engine);
app.set('view engine', 'php');

// Middleware phpExpress (GUNAKAN INI HANYA UNTUK FASTCGI)
app.all(/.+\.php$/, (req, res, next) => {
    phpExpress.run(req, res, next);
});

app.get('/', (req, res) => {
    res.render('index.php');
});

app.listen(port, () => {
    console.log('\x1b[32m',`Server now is running in http://localhost:${port}`);
});
