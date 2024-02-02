import express from 'express';
import cors from 'cors';
import helmet from "helmet";
import catchAllErrors from "../domain/errors/catchAllErrors.js";
import CommandeRoutes from './routes/CommandeRoutes.js';
import MessagesService from "./services/MessagesService.js";
let messagesService = new MessagesService();
messagesService.messageEnCommande();

const app = express();
app.use(express.json());

//midleware
app.use(cors());
app.use(helmet());
app.use("/commandes", CommandeRoutes);



//app.use(catch404Errors);
app.use(catchAllErrors);

export default app;