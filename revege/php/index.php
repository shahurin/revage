<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>LINE風チャット</title>
  <style>
    body {
      font-family: "Helvetica Neue", sans-serif;
      background-color: #e5ddd5;
      margin: 0;
      padding: 0;
    }

    .chat-container {
      max-width: 600px;
      margin: 0 auto;
      height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .chat-box {
      flex: 1;
      padding: 10px;
      overflow-y: scroll;
      background: #f0f0f0;
    }

    .message {
      margin: 10px 0;
      display: flex;
      align-items: flex-end;
    }

    .message.you {
      justify-content: flex-end;
    }

    .message .bubble {
      max-width: 70%;
      padding: 10px 15px;
      border-radius: 15px;
      position: relative;
    }

    .message.you .bubble {
      background-color: #dcf8c6;
      border-bottom-right-radius: 0;
    }

    .message.other .bubble {
      background-color: #ffffff;
      border-bottom-left-radius: 0;
    }

    .chat-input {
      display: flex;
      padding: 10px;
      background: #fff;
    }

    input[type="text"] {
      flex: 1;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 20px;
      margin-right: 10px;
    }

    #send {
      padding: 10px 15px;
      border: none;
      background-color: #4caf50;
      color: white;
      border-radius: 20px;
      cursor: pointer;
    }

    .name-input {
      padding: 10px;
      background: #fff;
      text-align: center;
    }
  </style>
</head>
<body>
<div class="chat-container">
  <div class="name-input">
    <input type="text" id="name" placeholder="あなたの名前を入力" />
  </div>
  <div class="chat-box" id="chat-box"></div>
  <div class="chat-input">
    <input type="text" id="message" placeholder="メッセージを入力..." />
    <button id="send">送信</button>
  </div>
</div>

<script>
  function loadChat() {
    fetch('chat.php')
      .then(res => res.json())
      .then(data => {
        const box = document.getElementById('chat-box');
        box.innerHTML = '';

        const username = document.getElementById('name').value.trim();

        data.forEach(msg => {
          const div = document.createElement('div');
          div.className = 'message ' + (msg.name === username ? 'you' : 'other');

          const bubble = document.createElement('div');
          bubble.className = 'bubble';
          bubble.textContent = msg.name + ': ' + msg.message;

          div.appendChild(bubble);
          box.appendChild(div);
        });

        box.scrollTop = box.scrollHeight;
      });
  }

  document.getElementById('send').addEventListener('click', () => {
    const name = document.getElementById('name').value.trim();
    const message = document.getElementById('message').value.trim();

    if (name && message) {
      fetch('chat.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `name=${encodeURIComponent(name)}&message=${encodeURIComponent(message)}`
      }).then(() => {
        document.getElementById('message').value = '';
        loadChat();
      });
    }
  });

  setInterval(loadChat, 2000);
  loadChat();
</script>
</body>
</html>
