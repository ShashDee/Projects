using MediatR;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Logging;
using System;
using System.Collections.Generic;
using System.Net;
using System.Threading.Tasks;
using Ordering.Api.Application.ViewModels;
using Ordering.Api.Application.Queries;
using Ordering.Api.Application.Commands;

namespace Ordering.Api.Controllers
{
    [Produces("application/json")]
    [Route("api/v1/[controller]")]
    [ApiController]
    public class ProductController : ControllerBase
    {
        private readonly IMediator _mediator;
        private readonly IProductQueries _productQueries;
        private readonly ILogger<ProductController> _logger;

        public ProductController(IMediator mediator, IProductQueries productQueries, ILogger<ProductController> logger)
        {
            _mediator = mediator ?? throw new ArgumentNullException(nameof(mediator));
            _productQueries = productQueries ?? throw new ArgumentNullException(nameof(productQueries));
            _logger = logger ?? throw new ArgumentNullException(nameof(logger));
        }

        [Route("getProducts")]
        [HttpGet]
        [ProducesResponseType(typeof(Product), (int)HttpStatusCode.OK)]
        [ProducesResponseType((int)HttpStatusCode.NotFound)]
        public async Task<ActionResult<IEnumerable<Product>>> GetProductsAsync()
        {
            var products = await _productQueries.GetProductsAsync();

            return Ok(products);
        }

        [Route("getProductById")]
        [HttpGet]
        [ProducesResponseType(typeof(Product), (int)HttpStatusCode.OK)]
        [ProducesResponseType((int)HttpStatusCode.NotFound)]
        public async Task<ActionResult<Product>> GetProductByIdAsync(Guid id)
        {
            var product = await _productQueries.GetProductByIdAsync(id);

            return Ok(product);
        }

        [Route("getProductsByName")]
        [HttpGet]
        [ProducesResponseType(typeof(Product), (int)HttpStatusCode.OK)]
        [ProducesResponseType((int)HttpStatusCode.NotFound)]
        public async Task<ActionResult<IEnumerable<Product>>> GetProductsByNameAsync(string name)
        {
            var products = await _productQueries.GetProductsByNameAsync(name);

            return Ok(products);
        }

        [Route("create")]
        [HttpPost]
        [ProducesResponseType(typeof(Guid), (int)HttpStatusCode.OK)]
        [ProducesResponseType((int)HttpStatusCode.BadRequest)]
        public async Task<ActionResult<Guid>> AddProduct([FromBody] AddProductCommand addProductCommand)
        {
            _logger.LogInformation(
                "----- Sending command: {CommandName} - {IdProperty}: {CommandId} ({@Command})",
                nameof(addProductCommand),
                nameof(addProductCommand.Name),
                addProductCommand.Name,
                addProductCommand);

            return await _mediator.Send(addProductCommand);
        }

        [Route("update")]
        [HttpPut]
        [ProducesResponseType(typeof(bool), (int)HttpStatusCode.OK)]
        [ProducesResponseType((int)HttpStatusCode.BadRequest)]
        public async Task<ActionResult<bool>> UpdatedProduct([FromBody] UpdateProductCommand updateProductCommand)
        {
            _logger.LogInformation(
                "----- Sending command: {CommandName} - {IdProperty}: {CommandId} ({@Command})",
                nameof(updateProductCommand),
                nameof(updateProductCommand.Id),
                updateProductCommand.Id,
                updateProductCommand);

            return await _mediator.Send(updateProductCommand);
        }

        [Route("delete")]
        [HttpDelete]
        [ProducesResponseType(typeof(bool), (int)HttpStatusCode.OK)]
        [ProducesResponseType((int)HttpStatusCode.BadRequest)]
        public async Task<ActionResult<bool>> DeleteProduct(Guid id)
        {
            var deleteProductCommand = new DeleteProductCommand(id);

            _logger.LogInformation(
                "----- Sending command: {CommandName} - {IdProperty}: {CommandId} ({@Command})",
                nameof(deleteProductCommand),
                nameof(deleteProductCommand.Id),
                deleteProductCommand.Id,
                deleteProductCommand);

            return await _mediator.Send(deleteProductCommand);
        }
    }
}
