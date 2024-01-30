export default function catchAllErrors(err, req, res, next) {
    if(res.headersSent){
        return next(err);
    }
    res.sendStatus(err);
};
