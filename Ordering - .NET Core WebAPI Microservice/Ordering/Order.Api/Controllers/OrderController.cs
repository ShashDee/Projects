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
    public class OrderController : ControllerBase
    {
        private readonly IMediator _mediator;
        private readonly IOrderQueries _orderQueries;
        private readonly ILogger<OrderController> _logger;

        public OrderController(IMediator mediator, IOrderQueries orderQueries, ILogger<OrderController> logger)
        {
            _mediator = mediator ?? throw new ArgumentNullException(nameof(mediator));
            _orderQueries = orderQueries ?? throw new ArgumentNullException(nameof(orderQueries));
            _logger = logger ?? throw new ArgumentNullException(nameof(logger));
        }

        [Route("getOrders")]
        [HttpGet]
        [ProducesResponseType(typeof(Product), (int)HttpStatusCode.OK)]
        [ProducesResponseType((int)HttpStatusCode.NotFound)]
        public async Task<ActionResult<IEnumerable<Order>>> GetOrdersAsync()
        {
            var orders = await _orderQueries.GetOrdersAsync();

            return Ok(orders);
        }

        [Route("getOrderById")]
        [HttpGet]
        [ProducesResponseType(typeof(Product), (int)HttpStatusCode.OK)]
        [ProducesResponseType((int)HttpStatusCode.NotFound)]
        public async Task<ActionResult<Order>> GetOrderByIdAsync(Guid id)
        {
            var order = await _orderQueries.GetOrderByIdAsync(id);

            return Ok(order);
        }

        [Route("getOrdersByProductId")]
        [HttpGet]
        [ProducesResponseType(typeof(Product), (int)HttpStatusCode.OK)]
        [ProducesResponseType((int)HttpStatusCode.NotFound)]
        public async Task<ActionResult<IEnumerable<Product>>> GetProductsByNameAsync(Guid productId)
        {
            var orders = await _orderQueries.GetOrdesByProductIdAsync(productId);

            return Ok(orders);
        }

        [Route("create")]
        [HttpPost]
        [ProducesResponseType(typeof(Guid), (int)HttpStatusCode.OK)]
        [ProducesResponseType((int)HttpStatusCode.BadRequest)]
        public async Task<ActionResult<Guid>> AddOrder([FromBody] AddOrderCommand addOrderCommand)
        {
            _logger.LogInformation(
                "----- Sending command: {CommandName} - {IdProperty}: {CommandId} ({@Command})",
                nameof(addOrderCommand),
                nameof(addOrderCommand.Description),
                addOrderCommand.Description,
                addOrderCommand);

            return await _mediator.Send(addOrderCommand);
        }

        [Route("update")]
        [HttpPut]
        public async Task<ActionResult<bool>> UpdatedOrder([FromBody] UpdateOrderCommand updateOrderCommand)
        {
            _logger.LogInformation(
               "----- Sending command: {CommandName} - {IdProperty}: {CommandId} ({@Command})",
               nameof(updateOrderCommand),
               nameof(updateOrderCommand.Id),
               updateOrderCommand.Id,
               updateOrderCommand);

            return await _mediator.Send(updateOrderCommand);
        }

        [Route("delete")]
        [HttpDelete]
        [ProducesResponseType(typeof(bool), (int)HttpStatusCode.OK)]
        [ProducesResponseType((int)HttpStatusCode.BadRequest)]
        public async Task<ActionResult<bool>> DeleteOrder(Guid id)
        {
            var deleteOrderCommand = new DeleteOrderCommand(id);

            _logger.LogInformation(
               "----- Sending command: {CommandName} - {IdProperty}: {CommandId} ({@Command})",
               nameof(deleteOrderCommand),
               nameof(deleteOrderCommand.Id),
               deleteOrderCommand.Id,
               deleteOrderCommand);

            return await _mediator.Send(new DeleteOrderCommand(id));
        }
    }
}
