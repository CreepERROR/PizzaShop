import ('mongoose')

const CommandSchema = new.mongoose.Schema({
    id: String,
    date_commande: String,
    delai: Int,
    montant_total: Float,
    mail_client: String,
    type_livraison: Int,
    
})