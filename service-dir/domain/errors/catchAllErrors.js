const catchAllErrors = (err, req, res, next) => {
    res.sendStatus(err);
};
export default catchAllErrors;