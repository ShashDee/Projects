using NUnit.Framework;
using System;
using System.Collections.Generic;
using System.Text;
using TFNValidatorApp.Api.Services;

namespace TFNValidatorApp.UnitTests.Api.Services
{
    [TestFixture]
    class StoreValidationAttemptsServiceTests
    {
        [Test]
        public void StoreValidationAttempts_PassCurrentAttempt_ReturnListWithOneItem()
        {
            var result = new StoreValidationAttemptsService().GetValidationAttemptsIn30Secs("38593474");

            Assert.AreEqual(1, result.Count);
        }

        [Test]
        [TestCase(null)]
        [TestCase("")]
        public void StoreValidationAttempts_PassNullorEmptyStringAsCurrentAttempt_ReturnEmptyList(string tfn)
        {
            var result = new StoreValidationAttemptsService().GetValidationAttemptsIn30Secs(tfn);

            Assert.AreEqual(0, result.Count);
        }
    }
}
