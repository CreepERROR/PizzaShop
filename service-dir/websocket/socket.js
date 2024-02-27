const WebSocket = require('ws');
const amqp = require('amqplib/callback_api');

const server = new WebSocket.Server({ port: 3000, clientTracking: true });
const clients = new Map();

amqp.connect('amqp://localhost', (err, connection) => {
  if (err) throw err;

  connection.createChannel((err, channel) => {
    if (err) throw err;

    channel.assertQueue('suivi_commandes', { durable: false });

    channel.consume('suivi_commandes', (message) => {
      const commandId = message.fields.routingKey;
      const clientSocket = clients.get(commandId);

      if (clientSocket) {
        clientSocket.send(message.content.toString());
      }
    }, { noAck: true });
  });
});

server.on('connection', (clientSocket) => {
  clientSocket.on('error', console.error);

  clientSocket.on('message', (message) => {
    const commandId = JSON.parse(message).commandId;
    clients.set(commandId, clientSocket);

    clientSocket.send(JSON.stringify({ commandId, message: 'Vous êtes abonné au suivi de cette commande.' }));
  });

  clientSocket.on('close', () => {
    clients.forEach((value, key) => {
      if (value === clientSocket) {
        clients.delete(key);
      }
    });
  });
});