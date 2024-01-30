import ('express');
let router = express.Router();
import CommandeController from '../controllers/CommandeController.js';

router
    .route('/commandes')
    .get(CommandeController)
    .all((req, res, next) => {

    });

module.exports = router;