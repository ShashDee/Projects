"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var api_1 = require("./api");
exports.ValidateTFN = function (tfn) {
    return api_1.default.post("/validate", { TFN: tfn })
        .then(function (response) { return response; })
        .catch(function (error) {
        throw error;
    });
};
//# sourceMappingURL=Validator.js.map