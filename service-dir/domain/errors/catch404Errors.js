const catch404Errors = (req, res, next) => {
    res.sendStatus(404);
}