import express from 'express';
import cors from 'cors';
import helmet from "helmet";
import catchAllErrors from "../domain/errors/catchAllErrors.js";

const app = express();
app.use(express.json());

//midleware
app.use(cors());
app.use(helmet());

//routes
app.get('/', (req, res) =>
    res.send('Hello World!'));

app.use(catch404Errors);
app.use(catchAllErrors);

export default app;