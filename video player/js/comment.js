const express = require('express');
const app = express();
const fs = require('fs');
const sd = require('silly-datetime');
const readline = require('readline');

app.use(express.static('./public'));

let oldHtmlContent = fs.readFileSync('./index.html').toString();

app.get('/', function(req, res) {
    res.send(oldHtmlContent);
    fs.writeFileSync('records.txt', '');
});

app.get('/comment', function(req, res) {

    writeRecord(req.query.comment, sd.format(new Date(), 'YYYY-MM-DD HH:mm'));

    let newHtmlContent = '';
    let r = /\d{4}-\d{2}-\d{2} \d{2}:\d{2}/
    let floorNumber = 2;
    let comment = '';

    const r1 = readline.createInterface({
        input: fs.createReadStream('./records.txt')
    })
    r1.on('line', (line) => {
        if (r.test(line)) {

            newHtmlContent =
                `<div class="comment">
                <span class="comment-avatar">
                <img src="avatar1.jpg" alt="avatar">
                </span>
                <div class="comment-content">
                    <p class="comment-content-name">EdmundDZhang</p>
                    <p class="comment-content-article">${comment}</p>
                    <p class="comment-content-footer">
                        <span class="comment-content-footer-id">#${++floorNumber}</span>
                        <span class="comment-content-footer-device">来自安卓客户端</span>
                        <span class="comment-content-footer-timestamp">${line}</span>
                    </p>
                </div>
                <div class="cls"></div>
                </div>` + newHtmlContent;
            comment = '';
        } else {
            comment += line;
        }
    }).on('close', () => {
        res.send(oldHtmlContent.replace('<div class="comment-list" id="commentList">', '<div class="comment-list" id="commentList">\n' + newHtmlContent));
    })
})

function writeRecord(comment, datetime) {
    fs.writeFileSync('./records.txt', `${comment}\n${datetime}\n`, { flag: 'a' });
}

app.listen(8888, '127.0.0.1');