import express from 'express';
import cors from 'cors';
import helmet from "helmet";

var router = express.Router();
const app = express();
const port = process.env.PORT || 3000;
app.use(express.json());

//midleware
app.use(cors());
app.use(helmet());

//routes
app.get('/', (req, res) =>
    res.send('Hello World!'));

app.listen(port, () =>
    console.log(`app listening on port ${port}!`
    )
);
