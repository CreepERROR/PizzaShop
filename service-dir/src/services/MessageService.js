import amqp from 'amqplib';

const exchange = 'pizzashop';  
const routingKey = 'suivi';   
const conn = await amqp.connect(rabbitmq);
const channel = await conn.createChannel();

const msg = JSON.stringify({ id: 1, pizza: '4 fromages' });

channel.publish(exchange, routingKey, Buffer.from(msg));

const queue = 'suivi_commandes';
channel.consume(queue, (msg) => {
    let data = JSON.parse(msg.content);
    channel.ack(msg);
});
