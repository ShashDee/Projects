using System;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Caching.Memory;
using Microsoft.Extensions.Options;
using TFNValidatorApp.Api.Services;
using TFNValidatorApp.Application.TFN.Validators;
using TFNValidatorApp.Domain.Models;

namespace TFNValidatorApp.Api.Controllers
{
    [Produces("application/json")]
    [Route("api/v1/[controller]")]
    [ApiController]
    public class TFNValidatorController : ControllerBase
    {
        private readonly IOptions<MockValidationSettings> _mockValidationSettings;
        private readonly ITFNValidator _tfnValidator;
        private readonly IMockValidator _mockValidator;
        private readonly IStoreValidationAttemptsService _storeValidationAttemptsService;

        public TFNValidatorController(IOptions<MockValidationSettings> mockValidationSettings, ITFNValidator tfnValidator, IMockValidator mockValidator, IStoreValidationAttemptsService storeValidationAttemptsService)
        {
            _mockValidationSettings = mockValidationSettings ?? throw new ArgumentNullException(nameof(mockValidationSettings));
            _tfnValidator = tfnValidator ?? throw new ArgumentNullException(nameof(tfnValidator));
            _mockValidator = mockValidator ?? throw new ArgumentNullException(nameof(mockValidator));
            _storeValidationAttemptsService = storeValidationAttemptsService ?? throw new ArgumentNullException(nameof(storeValidationAttemptsService));
        }

        [Route("validate")]
        [HttpPost]
        public IActionResult ValidateTFN([FromBody] TaxFileNumber tfn)
        {
            bool mockValidation = _mockValidationSettings.Value.MockValidation;

            var result = mockValidation ? _mockValidationSettings.Value.MockResult ? _mockValidator.MockValidateAlwaysTrue() : _mockValidator.MockValidateAlwaysFalse() : _tfnValidator.Validate(tfn.TFN, _storeValidationAttemptsService.GetValidationAttemptsIn30Secs(tfn.TFN));

            return Ok(result);
        }
    }
}
