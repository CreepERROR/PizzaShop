import express from 'express';
import cors from 'cors';
import helmet from "helmet";
import CommandeRoutes from './routes/CommandeRoutes.js';

const app = express();
const port = process.env.PORT || 3000;
app.use(express.json());

//midleware
app.use(cors());
app.use(helmet());
app.use("/commandes", CommandeRoutes);



app.listen(port, () =>
    console.log(`app listening on port ${port}!`
    )
);
