using Moq;
using NUnit.Framework;
using System;
using System.Collections.Generic;
using System.Text;
using TFNValidatorApp.Application.TFN.Validators;

namespace TFNValidatorApp.UnitTests.Application.TFN.Validators
{
    [TestFixture]
    class MockValidatorTests
    {
        [Test]
        public void AlwaysTrueMockValidator_ValidAndInvalidTFNs_ReturnTrue()
        {
            var result = new MockValidator().MockValidateAlwaysTrue();

            Assert.AreEqual(true, result.Status);
        }

        [Test]
        public void AlwaysFalseMockValidator_ValidAndInvalidTFNs_ReturnFalse()
        {
            var result = new MockValidator().MockValidateAlwaysFalse();

            Assert.AreEqual(false, result.Status);
        }
    }
}
