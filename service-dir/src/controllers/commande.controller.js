import ('../services/CommandesServices')

exports.getCommand = async function(req,res, next){
    let page = req.params.page ? req.params.limit:1;
    let limit = req.params.limit ? req.params.limit: 10;
    try{
        let command = await CommandService.getCommand({}, page, limit)
        return res.status(200).json({ status: 200, data:useSSRContext, message:"Succesfully"})
    } catch (e){
        return res.status(400).json({status:400, message: e.message});
    }
}