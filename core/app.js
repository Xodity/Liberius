const express = require('express');
const phpExpress = require('php-express')({
    binPath: 'php'
});
const port = 3000;
const app = express();

app.use((req, res, next) => {
    console.log(`[${new Date().toLocaleString()}] ${req.method} REQUEST TO ${req.url}`);
    next();
});

app.set('views', './app/views');
app.engine('php', phpExpress.engine);
app.set('view engine', 'php');

app.all(/.+\.php$/, (req, res, next) => {
    phpExpress.run(req, res, next);
});

app.get('/', (req, res) => {
    res.render('index.php');
});

app.listen(port, () => {
    console.log('\x1b[32m', `Server now is running in \x1b[37mhttp://localhost:${port}\x1b[0m`);
});
